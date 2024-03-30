<?php

namespace Service;

use App\Config\Database;
use App\Domain\Admin;
use App\Exception\ValidationException;
use App\Model\Login\UserLoginRequest;
use App\Repository\AdminRepository;
use App\Service\AdminService;
use PHPUnit\Framework\TestCase;

class AdminServiceTest extends TestCase
{
    private AdminService $adminService;
    private AdminRepository $adminRepository;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $this->adminRepository = new AdminRepository($connection);
        $this->adminService = new AdminService($this->adminRepository);

        $this->adminRepository->deleteAll();
    }

    public function testLoginNotFound()
    {
        $this->expectException(ValidationException::class);
        $request = new UserLoginRequest();
        $request->username = "paujan";
        $request->password = "gagah";

        $this->adminService->login($request);
    }

    public function testLoginWrongPassword()
    {
        $admin = new Admin();
        $admin->username = "admin";
        $admin->password = password_hash("admin", PASSWORD_BCRYPT);
        $admin->nama_admin = "AKUADMIN";
        $this->adminRepository->saveAdmin($admin);

        $this->expectException(ValidationException::class);
        $request = new UserLoginRequest();
        $request->username = "paujan";
        $request->password = "salah";

        $this->adminService->login($request);
    }

    public function testLoginSuccess()
    {
        $admin = new Admin();
        $admin->username = "admin";
        $admin->password = password_hash("admin", PASSWORD_BCRYPT);
        $admin->nama_admin = "AKUADMIN";
        $this->adminRepository->saveAdmin($admin);


        $request = new UserLoginRequest();
        $request->username = "admin";
        $request->password = "admin";

        $response = $this->adminService->login($request);

        self::assertEquals($admin->username, $response->admin->username);
        self::assertEquals($admin->password, $response->admin->password);
    }

}
