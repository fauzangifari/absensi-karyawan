<?php

namespace App\Middleware;

use App\App\View;
use App\Config\Database;
use App\Repository\AdminRepository;
use App\Repository\KaryawanRepository;
use App\Repository\SessionRepository;
use App\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $karyawanRepository = new KaryawanRepository(Database::getConnection());
        $adminRepository = new AdminRepository(Database::getConnection());
        $this->sessionService = new SessionService( $sessionRepository, $karyawanRepository, $adminRepository);
    }

    public function karyawan(): void
    {
        $karyawan = $this->sessionService->currentSessionKaryawan();
        if ($karyawan == null) {
            View::redirect('/login');
        }
    }

    public function admin(): void
    {
        $admin = $this->sessionService->currentSessionAdmin();
        if ($admin == null) {
            View::redirect('/login');
        }
    }

    function before(): void
    {
        if (isset($_GET['role'])) {
            if ($_GET['role'] == 'karyawan') {
                $this->karyawan();
            } else {
                $this->admin();
            }
        }
    }
}