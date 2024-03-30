<?php

namespace Repository;

use App\Config\Database;
use App\Domain\Admin;
use App\Repository\AdminRepository;
use PHPUnit\Framework\TestCase;

class AdminRepositoryTest extends TestCase
{
    private AdminRepository $adminRepository;

    protected function setUp(): void
    {
        $this->adminRepository = new AdminRepository(Database::getConnection());
        $this->adminRepository->deleteAll();
    }

    public function testSaveSuccess()
    {
        $admin = new Admin();
        $admin->username = "admin";
        $admin->password = "admin123";
        $admin->nama_admin = "Fauzan Gifari";
        $this->adminRepository->saveAdmin($admin);

        $result = $this->adminRepository->findByUsername($admin->username);

        self::assertEquals($admin->username, $result->username);
        self::assertEquals($admin->password, $result->password);
        self::assertEquals($admin->nama_admin, $result->nama_admin);

    }

    public function testFindByUsernameNotFound()
    {
        $result = $this->adminRepository->findByUsername("notfound");
        self::assertNull($result);
    }

    public function testFindByUsernameSuccess()
    {
        $admin = new Admin();
        $admin->username = "admin";
        $admin->password = "admin123";
        $admin->nama_admin = "Fauzan Gifari";
        $this->adminRepository->saveAdmin($admin);

        $result = $this->adminRepository->findByUsername($admin->username);

        self::assertEquals($admin->username, $result->username);
        self::assertEquals($admin->password, $result->password);
        self::assertEquals($admin->nama_admin, $result->nama_admin);
    }
}
