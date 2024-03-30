<?php

namespace App\Controller;

use App\App\View;
use App\Config\Database;
use App\Repository\AdminRepository;
use App\Repository\KaryawanRepository;
use App\Repository\SessionRepository;
use App\Service\SessionService;

class DashboardController
{
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $karyawanRepository = new KaryawanRepository($connection);
        $adminRepository = new AdminRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $karyawanRepository, $adminRepository);
    }

    public function dashboardKaryawan()
    {
        $karyawan = $this->sessionService->currentSessionKaryawan();
        if ($karyawan == null) {
            View::redirect('/login');
        } else {
            View::render('Dashboard/dashboardKaryawan',[
                'title' => 'Dashboard Karyawan',
                'karyawan' => [
                    "name" => $karyawan->nama_karyawan
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
            View::render('Dashboard/dashboardAdmin',[
                'title' => 'Dashboard Admin',
                'admin' => [
                    "name" => $admin->nama_admin
                ]
            ]);
        }
    }
}