<?php

namespace App\App {
    function header(string $value){
        echo $value;
    }
}

namespace Controller {

    use App\Config\Database;
    use App\Controller\DashboardController;
    use App\Repository\AbsenRepository;
    use PHPUnit\Framework\TestCase;

    class DashboardControllerTest extends TestCase
    {
        private DashboardController $dashboardController;
        private AbsenRepository $absenRepository;

        protected function setUp(): void
        {
            $this->dashboardController = new DashboardController();

            $this->absenRepository = new AbsenRepository(Database::getConnection());
            $this->absenRepository->deleteAll();

            putenv('ENVIRONMENT=test');
        }

        public function testAbsen()
        {
            $_POST['id_absen'] = 'ABS1909';
            $_POST['username_karyawan'] = 'fauzangifari';
            $_POST['nama_karyawan'] = 'Fauzan Gifari';
            $_POST['tanggal_absen'] = '2021-09-01';
            $_POST['jam_masuk'] = '08:00:00';
            $_POST['jam_keluar'] = '17:00:00';
            $_POST['keterangan'] = 'Hadir';

            $this->dashboardController->createAttedance();
            $this->expectOutputRegex("[Location: /login]");
        }
    }
}
