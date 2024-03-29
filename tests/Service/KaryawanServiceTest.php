<?php

namespace Service;

use App\Config\Database;
use App\Domain\Karyawan;
use App\Model\KaryawanRegisterRequest;
use App\Repository\KaryawanRepository;
use App\Service\KaryawanService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class KaryawanServiceTest extends TestCase
{
    private KaryawanService $karyawanService;
    private KaryawanRepository $karyawanRepository;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $this->karyawanRepository = new KaryawanRepository($connection);
        $this->karyawanService = new KaryawanService($this->karyawanRepository);

        $this->karyawanRepository->deleteAll();
    }

    public function testRegisterSuccess()
    {
        $request = new KaryawanRegisterRequest();
        $request->username = "budilahnamanya";
        $request->password = "password";
        $request->nama_karyawan = "Budi";
        $request->alamat_karyawan = "Jl. Juanda 4";
        $request->no_telp_karyawan = "08123456789";

        $response = $this->karyawanService->register($request);

        self::assertEquals($request->username, $response->karyawan->username);

        self::assertNotEquals($request->password, $response->karyawan->password);
        self::assertTrue(password_verify($request->password, $response->karyawan->password));

        self::assertEquals($request->nama_karyawan, $response->karyawan->nama_karyawan);
        self::assertEquals($request->alamat_karyawan, $response->karyawan->alamat_karyawan);
        self::assertEquals($request->no_telp_karyawan, $response->karyawan->no_telp_karyawan);

    }

    public function testRegisterFailedIdKaryawanExists()
    {
        try {
            $request = new KaryawanRegisterRequest();
            $request->username = "";
            $request->password = "";
            $request->nama_karyawan = "";
            $request->alamat_karyawan = "";
            $request->no_telp_karyawan = "";

            $this->karyawanService->register($request);
        } catch (\Exception $exception) {
            self::assertInstanceOf(InvalidArgumentException::class, $exception);
            self::assertEquals("ID Karyawan is required", $exception->getMessage());
        }
    }

    public function testRegisterDuplicate()
    {
        try {
            $karyawan = new Karyawan();
            $karyawan->username = "budilahnamanya";
            $karyawan->password = "password";
            $karyawan->nama_karyawan = "Budi";
            $karyawan->alamat_karyawan = "Jl. Juanda 4";
            $karyawan->no_telp_karyawan = "08123456789";
            $this->karyawanRepository->saveKaryawan($karyawan);

            $request = new KaryawanRegisterRequest();
            $request->username = "budilahnamanya";
            $request->password = "password";
            $request->nama_karyawan = "Budi";
            $request->alamat_karyawan = "Jl. Juanda 4";
            $request->no_telp_karyawan = "08123456789";

            $this->karyawanService->register($request);
        } catch (\Exception $exception) {
            self::assertInstanceOf(InvalidArgumentException::class, $exception);
            self::assertEquals("ID Karyawan already exists", $exception->getMessage());
        }
    }
}
