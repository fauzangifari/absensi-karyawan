<?php

namespace App\Controller;

use App\App\View;
use App\Config\Database;
use App\Exception\ValidationException;
use App\Model\Login\UserLoginRequest;
use App\Model\Register\KaryawanRegisterRequest;
use App\Repository\AdminRepository;
use App\Repository\KaryawanRepository;
use App\Repository\ManajerRepository;
use App\Repository\SessionRepository;
use App\Service\AdminService;
use App\Service\KaryawanService;
use App\Service\ManajerService;
use App\Service\SessionService;

class UserController
{
    private KaryawanService $karyawanService;
    private AdminService $adminService;
    private SessionService $sessionService;
    private ManajerService $manajerService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $karyawanRepository = new KaryawanRepository($connection);
        $this->karyawanService = new KaryawanService($karyawanRepository);

        $adminRepository = new AdminRepository($connection);
        $this->adminService = new AdminService($adminRepository);

        $manajerRepository = new ManajerRepository($connection);
        $this->manajerService = new ManajerService($manajerRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $karyawanRepository, $adminRepository, $manajerRepository);
    }

    public function register()
    {
        View::render('Register/register',[
            'title' => 'Sign Up Karyawan',
        ]);
    }

    public function postRegister()
    {
        $request = new KaryawanRegisterRequest();
        $request->nama_karyawan = $_POST['name'];
        $request->alamat_karyawan = $_POST['address'];
        $request->no_telp_karyawan = $_POST['phone_number'];
        $request->username = $_POST['username'];
        $request->password = $_POST['password'];

        try {
            $this->karyawanService->register($request);
            View::redirect('/login');
        } catch (\Exception $e) {
            View::render('Register/register',[
                'title' => 'Sign Up Karyawan',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function login()
    {
        View::render('Login/login',[
            'title' => 'Login'
        ]);
    }

    public function postLogin()
    {
        $request = new UserLoginRequest();
        $request->username = $_POST['username'];
        $request->password = $_POST['password'];

        try {
            if ($_POST['role'] === 'admin') {
                $response = $this->adminService->login($request);
                $this->sessionService->createSession($response->admin->username);
                View::redirect('/dashboard-admin');
            } elseif ($_POST['role'] === 'karyawan') {
                $response = $this->karyawanService->login($request);
                $this->sessionService->createSession($response->karyawan->username);
                View::redirect('/dashboard-karyawan');
            } elseif ($_POST['role'] === 'manajer') {
                $response = $this->manajerService->login($request);
                $this->sessionService->createSession($response->manajer->username);
                View::redirect('/dashboard-manajer');
            } else {
                throw new ValidationException('Role Required');
            }
        } catch (ValidationException $e) {
            View::render('Login/login',[
                'title' => 'Login',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        $this->sessionService->destroySession();
        View::redirect('/login');
    }

}