<?php

namespace App\Middleware;

use App\App\View;
use App\Config\Database;
use App\Repository\AdminRepository;
use App\Repository\KaryawanRepository;
use App\Repository\ManajerRepository;
use App\Repository\SessionRepository;
use App\Service\SessionService;

class MustNotLoginMiddleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $karyawanRepository = new KaryawanRepository(Database::getConnection());
        $adminRepository = new AdminRepository(Database::getConnection());
        $manajerRepository = new ManajerRepository(Database::getConnection());
        $this->sessionService = new SessionService( $sessionRepository, $karyawanRepository, $adminRepository, $manajerRepository);
    }

    public function karyawan(): void
    {
        $karyawan = $this->sessionService->currentSessionKaryawan();
        if ($karyawan != null) {
            View::redirect('/dashboard-karyawan');
        }
    }

    public function admin(): void
    {
        $admin = $this->sessionService->currentSessionAdmin();
        if ($admin != null) {
            View::redirect('/dashboard-admin');
        }
    }

    public function manajer(): void
    {
        $manajer = $this->sessionService->currentSessionManajer();
        if ($manajer != null) {
            View::redirect('/dashboard-manajer');
        }
    }

    function before(): void
    {
        if (isset($_GET['role'])) {
            if ($_GET['role'] == 'karyawan') {
                $this->karyawan();
            } elseif ($_GET['role'] == 'admin') {
                $this->admin();
            } elseif ($_GET['role'] == 'manajer') {
                $this->manajer();
            } else {
                View::redirect('/login');
            }
        }
    }
}