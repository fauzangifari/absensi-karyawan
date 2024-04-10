<?php

namespace App\Controller;

use App\App\View;
use App\Config\Database;
use App\Domain\Karyawan;
use App\Exception\ValidationException;
use App\Model\Absen\AbsenRequest;
use App\Model\Register\KaryawanRegisterRequest;
use App\Model\Register\ManajerRegisterRequest;
use App\Repository\AbsenRepository;
use App\Repository\AdminRepository;
use App\Repository\KaryawanRepository;
use App\Repository\ManajerRepository;
use App\Repository\SessionRepository;
use App\Service\AbsenService;
use App\Service\KaryawanService;
use App\Service\ManajerService;
use App\Service\SessionService;

class DashboardController
{
    private SessionService $sessionService;
    private KaryawanRepository $karyawanRepository;
    private KaryawanService $karyawanService;
    private AbsenService $absenService;
    private ManajerService $manajerService;
    private ManajerRepository $manajerRepository;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $adminRepository = new AdminRepository($connection);
        $karyawanRepository = new KaryawanRepository($connection);
        $manajerRepository = new ManajerRepository($connection);
        $absenRepository = new AbsenRepository($connection);

        $this->karyawanRepository = new KaryawanRepository($connection);
        $this->manajerRepository = new ManajerRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $karyawanRepository, $adminRepository, $manajerRepository);
        $this->absenService = new AbsenService($absenRepository);
        $this->karyawanService = new KaryawanService($karyawanRepository);
        $this->manajerService = new ManajerService($manajerRepository);
    }

    public function dashboardKaryawan()
    {
        $karyawan = $this->sessionService->currentSessionKaryawan();
        if ($karyawan == null) {
            View::redirect('/login');
        } else {
            View::render('Dashboard/dashboardKaryawan', [
                'title' => 'Dashboard Karyawan',
                'karyawan' => [
                    "name" => $karyawan->nama_karyawan,
                    "username" => $karyawan->username,
                ]
            ]);
        }
    }

    public function dashboardAdmin()
    {
        $admin = $this->sessionService->currentSessionAdmin();
        if ($admin == null) {
            View::redirect('/login');
        } else {
            View::render('Dashboard/dashboardAdmin', [
                'title' => 'Dashboard Admin',
                'admin' => [
                    "name" => $admin->nama_admin,
                    "count_karyawan" => $this->karyawanService->countKaryawan(),
                    "count_manajer" => $this->manajerService->countManajer(),
                    "karyawan_list" => $this->karyawanService->showAllKaryawan(),
                ]
            ]);
        }
    }

    public function dashboardManajer()
    {
        $manajer = $this->sessionService->currentSessionManajer();
        if ($manajer == null) {
            View::redirect('/login');
        } else {
            View::render('Dashboard/dashboardManajer', [
                'title' => 'Dashboard Manajer',
                'manajer' => [
                    "name" => $manajer->nama_manajer,
                    "karyawan_list" => $this->karyawanService->showAllKaryawan(),
                    "attendance_list" => $this->absenService->showAllAttedanceByDate(date('Y-m-d')),
                    "attendance_by_date" => $this->absenService->getAttedanceCountByDate(date('Y-m-d')),
                ]
            ]);
        }
    }

    public function handleEmployeeAction()
    {
        $admin = $this->sessionService->currentSessionAdmin();
        if ($admin == null) {
            View::redirect('/login');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
                $action = $_POST['action'];

                try {
                    if ($action === 'delete') {
                        $username = $_POST['username'];
                        $this->karyawanService->deleteKaryawan($username);
                    } elseif ($action === 'update') {
                        $username = $_POST['username'];
                        $karyawan = $this->karyawanRepository->findByUsername($username);
                        if ($karyawan == null) {
                            throw new \Exception("Karyawan with Username $username not found");
                        }

                        $karyawan->nama_karyawan = $_POST['updateName'];
                        $karyawan->alamat_karyawan = $_POST['updateAddress'];
                        $karyawan->no_telp_karyawan = $_POST['updatePhoneNumber'];
                        $this->karyawanService->updateKaryawan($karyawan);
                    } elseif ($action === 'create') {
                        $karyawan = $this->karyawanRepository->findByUsername($_POST['addUsername']);
                        if ($karyawan != null) {
                            throw new \Exception("Karyawan with Username " . $_POST['addUsername'] . " already exists");
                        }

                        $karyawan = new KaryawanRegisterRequest();
                        $karyawan->username = $_POST['addUsername'];
                        $karyawan->password = $_POST['addPassword'];
                        $karyawan->nama_karyawan = $_POST['addName'];
                        $karyawan->alamat_karyawan = $_POST['addAddress'];
                        $karyawan->no_telp_karyawan = $_POST['addPhoneNumber'];
                        $this->karyawanService->register($karyawan);
                    } else {
                        throw new \Exception("Invalid action");
                    }

                    View::redirect('/dashboard-admin/employee');
                } catch (ValidationException|\Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                View::redirect('/dashboard-admin/employee');
            }
        }
    }


    public function createAttedance()
    {
        $karyawan = $this->sessionService->currentSessionKaryawan();
        if ($karyawan == null) {
            View::redirect('/login');
        } else {
            $request = new AbsenRequest();
            $request->id_absen = 'ABS_' . random_int(1000, 9999) . '_' . date('YmdHis');
            $request->username_karyawan = $_POST['username'];
            $request->nama_karyawan = $_POST['nama_karyawan'];
            $request->tanggal_absen = $_POST['tanggal_absen'];
            $request->jam_masuk = $_POST['jam_masuk'];
            $request->jam_keluar = $_POST['jam_keluar'];
            $request->keterangan = $_POST['keterangan'];
            $request->alasan = $_POST['alasan'];
            $request->file = $_POST['file'];

            try {
                $this->absenService->createAbsen($request);
                View::redirect('/dashboard-karyawan');
            } catch (\Exception $e) {
                View::render('Dashboard/dashboardKaryawan', [
                    'title' => 'Dashboard Karyawan',
                    'karyawan' => [
                        "name" => $this->sessionService->currentSessionKaryawan()->nama_karyawan,
                        "username" => $this->sessionService->currentSessionKaryawan()->username,
                        "error" => $e->getMessage(),
                    ]
                ]);
            }

        }
    }

    public function tableEmployee()
    {
        $admin = $this->sessionService->currentSessionAdmin();
        if ($admin == null) {
            View::redirect('/login');
        } else {
            View::render('Dashboard/tabelKaryawan', [
                'title' => 'Table Employee',
                'admin' => [
                    "name" => $admin->nama_admin,
                    "karyawan_list" => $this->karyawanService->showAllKaryawan(),
                ]
            ]);
        }
    }

    public function tableAttendance()
    {
        $admin = $this->sessionService->currentSessionAdmin();
        if ($admin == null) {
            View::redirect('/login');
        } else {
            $selectedDate = !empty($_GET['tanggalAbsen']) ? $_GET['tanggalAbsen'] : null;

            if ($selectedDate !== null) {
                $attendanceByDate = $this->absenService->showAllAttedanceByDate($selectedDate);
            } else {
                $attendanceByDate = $this->absenService->showAllAttedance();
            }

            View::render('Dashboard/tabelAbsensi', [
                'title' => 'Table Attendance',
                'admin' => [
                    "name" => $admin->nama_admin,
                    "absen_list" => $this->absenService->showAllAttedance(),
                    "attendance_by_date" => $attendanceByDate,
                ]
            ]);
        }
    }


    public function tableManager()
    {
        $admin = $this->sessionService->currentSessionAdmin();
        if ($admin == null) {
            View::redirect('/login');
        } else {
            View::render('Dashboard/tabelManajer', [
                'title' => 'Table Manager',
                'admin' => [
                    "name" => $admin->nama_admin,
                    "manajer_list" => $this->manajerService->showAllManajer(),
                ]
            ]);
        }
    }

    public function handleManagerAction()
    {
        $admin = $this->sessionService->currentSessionAdmin();
        if ($admin == null) {
            View::redirect('/login');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
                $action = $_POST['action'];

                try {
                    if ($action === 'delete') {
                        $username = $_POST['username'];
                        $this->manajerService->deleteManajer($username);
                    } elseif ($action === 'update') {
                        $username = $_POST['username'];
                        $manajer = $this->manajerRepository->findByUsername($username);
                        if ($manajer == null) {
                            throw new \Exception("Manager with Username $username not found");
                        }

                        $manajer->nama_manajer = $_POST['updateName'];
                        $manajer->alamat_manajer = $_POST['updateAddress'];
                        $manajer->no_telp_manajer = $_POST['updatePhoneNumber'];
                        $this->manajerService->updateManajer($manajer);
                    } elseif ($action === 'create') {
                        $manajer = $this->manajerRepository->findByUsername($_POST['addUsername']);
                        if ($manajer != null) {
                            throw new \Exception("Karyawan with Username " . $_POST['addUsername'] . " already exists");
                        }

                        $manajer = new ManajerRegisterRequest();
                        $manajer->username = $_POST['addUsername'];
                        $manajer->password = $_POST['addPassword'];
                        $manajer->nama_manajer = $_POST['addName'];
                        $manajer->alamat_manajer = $_POST['addAddress'];
                        $manajer->no_telp_manajer = $_POST['addPhoneNumber'];
                        $this->manajerService->register($manajer);
                    } else {
                        throw new \Exception("Invalid action");
                    }

                    View::redirect('/dashboard-admin/manager');
                } catch (ValidationException|\Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                View::redirect('/dashboard-admin/manager');
            }
        }
    }

    public function tableAttadanceManager()
    {
        $manajer = $this->sessionService->currentSessionManajer();
        if ($manajer == null) {
            View::redirect('/login');
        } else {
            View::render('Dashboard/tabelAbsensiManajer', [
                'title' => 'Table Attendance Manager',
                'manajer' => [
                    "name" => $manajer->nama_manajer,
                    "attendance_list" => $this->absenService->showAllAttedanceByDate(date('Y-m-d')),
                ]
            ]);
        }
    }
}