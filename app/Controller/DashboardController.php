<?php

namespace App\Controller;

use App\App\View;
use App\Config\Database;
use App\Model\Absen\AbsenRequest;
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
            View::render('Dashboard/dashboardAdmin', [
                'title' => 'Dashboard Admin',
                'admin' => [
                    "name" => $admin->nama_admin,
                    "count_karyawan" => $this->karyawanService->countKaryawan(),
                    "karyawan_list" => $this->karyawanService->showAllKaryawan(),
                ]
            ]);
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
}