<?php

namespace Repository;

use App\Config\Database;
use App\Domain\Karyawan;
use App\Repository\KaryawanRepository;
use PHPUnit\Framework\TestCase;

class KaryawanRepositoryTest extends TestCase
{

    private KaryawanRepository $karyawanRepository;

    protected function setUp(): void
    {
        $this->karyawanRepository = new KaryawanRepository(Database::getConnection());
        $this->karyawanRepository->deleteAll();
    }

    public function testSaveSuccess()
    {
        $karyawan = new Karyawan();
        $karyawan->username = "budi123";
        $karyawan->password = "password";
        $karyawan->nama_karyawan = "Budi";
        $karyawan->alamat_karyawan = "Jl. Juanda 4";
        $karyawan->no_telp_karyawan = "08123456789";
        $this->karyawanRepository->saveKaryawan($karyawan);

        $result = $this->karyawanRepository->findByUsername($karyawan->username);

        self::assertEquals($karyawan->username, $result->username);
        self::assertEquals($karyawan->password, $result->password);
        self::assertEquals($karyawan->nama_karyawan, $result->nama_karyawan);
        self::assertEquals($karyawan->alamat_karyawan, $result->alamat_karyawan);
        self::assertEquals($karyawan->no_telp_karyawan, $result->no_telp_karyawan);
    }

    public function testFindByIdNotFound()
    {
        $result = $this->karyawanRepository->findByUsername("notfound");
        self::assertNull($result);
    }
}
