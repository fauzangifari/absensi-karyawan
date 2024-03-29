<?php

namespace App\Controller;

use App\App\View;
use App\Config\Database;
use App\Exception\ValidationException;
use App\Model\Login\UserLoginRequest;
use App\Model\Register\KaryawanRegisterRequest;
use App\Repository\KaryawanRepository;
use App\Service\KaryawanService;

class UserController
{
    private KaryawanService $karyawanService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $karyawanRepository = new KaryawanRepository($connection);
        $this->karyawanService = new KaryawanService($karyawanRepository);
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
            'title' => 'Login Karyawan'
        ]);
    }

    public function postLogin()
    {
        $request = new UserLoginRequest();
        $request->username = $_POST['username'];
        $request->password = $_POST['password'];

        try {
            $this->karyawanService->login($request);
            View::redirect('/dashboard');
        } catch (ValidationException $e) {
            View::render('Login/login',[
                'title' => 'Login Karyawan',
                'error' => $e->getMessage()
            ]);
        }
    }
}