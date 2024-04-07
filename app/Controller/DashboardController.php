<?php

namespace App\Controller;

use App\App\View;
use App\Config\Database;
use App\Domain\Karyawan;
use App\Exception\ValidationException;
use App\Model\Absen\AbsenRequest;
use App\Model\Register\KaryawanRegisterRequest;
use App\Repository\AbsenRepository;
use App\Repository\AdminRepository;
use App\Repository\KaryawanRepository;
use App\Repository\SessionRepository;
use App\Service\AbsenService;
use App\Service\KaryawanService;
use App\Service\SessionService;

class DashboardController
{
    private SessionService $sessionService;
    private KaryawanRepository $karyawanRepository;
    private KaryawanService $karyawanService;
    private AbsenService $absenService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $adminRepository = new AdminRepository($connection);
        $karyawanRepository = new KaryawanRepository($connection);
        $absenRepository = new AbsenRepository($connection);

        $this->karyawanRepository = new KaryawanRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $karyawanRepository, $adminRepository);
        $this->absenService = new AbsenService($absenRepository);
        $this->karyawanService = new KaryawanService($karyawanRepository);
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
            $karyawan_list = $this->karyawanService->showAllKaryawan();
            View::render('Dashboard/dashboardAdmin', [
                'title' => 'Dashboard Admin',
                'admin' => [
                    "name" => $admin->nama_admin,
                    "count_karyawan" => $this->karyawanService->countKaryawan(),
                    "karyawan_list" => $karyawan_list,
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
                $username = $_POST['username'];

                try {
                    if ($action === 'delete') {
                        $this->karyawanService->deleteKaryawan($username);
                    } elseif ($action === 'update') {
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

                    View::redirect('/dashboard-admin/table');
                } catch (ValidationException|\Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                View::redirect('/dashboard-admin/table');
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
            View::render('Dashboard/tabelAbsensi', [
                'title' => 'Table Attendance',
                'admin' => [
                    "name" => $admin->nama_admin,
                    "absen_list" => $this->absenService->showAllAttedance(),
                ]
            ]);
        }
    }
}