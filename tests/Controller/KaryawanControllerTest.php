<?php

namespace App\App {
    function header(string $value){
        echo $value;
    }
}

namespace Controller {
    use App\Config\Database;
    use App\Controller\UserController;
    use App\Domain\Karyawan;
    use App\Repository\KaryawanRepository;
    use PHPUnit\Framework\TestCase;

    class KaryawanControllerTest extends TestCase
    {
        private UserController $karyawanController;
        private KaryawanRepository $karyawanRepository;

        protected function setUp(): void
        {
            $this->karyawanController = new UserController();

            $this->karyawanRepository = new KaryawanRepository(Database::getConnection());
            $this->karyawanRepository->deleteAll();

            putenv('ENVIRONMENT=test');
        }

        public function testRegister()
        {

            $this->karyawanController->register();
            $this->expectOutputRegex('[Create an Account!]');
            $this->expectOutputRegex('[Sign Up Karyawan]');
            $this->expectOutputRegex('[Employee Name]');
            $this->expectOutputRegex('[Address]');
            $this->expectOutputRegex('[Phone Number]');
            $this->expectOutputRegex('[Username]');
            $this->expectOutputRegex('[Password]');
        }

        public function testPostRegisterSuccess()
        {

            $_POST['name'] = 'Fauzan Gifari';
            $_POST['address'] = 'Jl. Juanda 4';
            $_POST['phone_number'] = '012331231';
            $_POST['username'] = 'fauzangifari';
            $_POST['password'] = 'kukangmesir';

            $this->karyawanController->postRegister();
            $this->expectOutputRegex("[Location: /login]");

        }

        public function testPostRegisterValidationError()
        {
            $_POST['name'] = 'Fauzan Gifari';
            $_POST['address'] = 'Jl. Juanda 4';
            $_POST['phone_number'] = '012331231';
            $_POST['username'] = '';
            $_POST['password'] = 'kukangmesir';

            $this->karyawanController->postRegister();
            $this->expectOutputRegex('[Create an Account!]');
            $this->expectOutputRegex('[Sign Up Karyawan]');
            $this->expectOutputRegex('[Employee Name]');
            $this->expectOutputRegex('[Address]');
            $this->expectOutputRegex('[Phone Number]');
            $this->expectOutputRegex('[Username]');
            $this->expectOutputRegex('[Password]');
            $this->expectOutputRegex('[Username, Password, Nama Karyawan, Alamat Karyawan, dan No Telp Karyawan can not blank.]');

        }

        public function testPostRegisterDuplicate()
        {
            $karyawan = new Karyawan();
            $karyawan->username = 'fauzangifari';
            $karyawan->password = 'kuangmesir';
            $karyawan->nama_karyawan = 'Fauzan Gifari';
            $karyawan->alamat_karyawan = 'Jl. Juanda 4';
            $karyawan->no_telp_karyawan = '012331231';

            $this->karyawanRepository->saveKaryawan($karyawan);

            $_POST['name'] = 'Fauzan Gifari';
            $_POST['address'] = 'Jl. Juanda 4';
            $_POST['phone_number'] = '012331231';
            $_POST['username'] = 'fauzangifari';
            $_POST['password'] = 'kukangmesir';

            $this->karyawanController->postRegister();
            $this->expectOutputRegex('[Create an Account!]');
            $this->expectOutputRegex('[Sign Up Karyawan]');
            $this->expectOutputRegex('[Employee Name]');
            $this->expectOutputRegex('[Address]');
            $this->expectOutputRegex('[Phone Number]');
            $this->expectOutputRegex('[Username]');
            $this->expectOutputRegex('[Password]');
            $this->expectOutputRegex('[Karyawan with Username Karyawan fauzangifari already exists.]');

        }
    }
}



