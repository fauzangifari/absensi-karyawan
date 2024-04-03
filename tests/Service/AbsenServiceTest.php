<?php

namespace Service;

use App\Config\Database;
use App\Domain\Absen;
use App\Model\Absen\AbsenRequest;
use App\Repository\AbsenRepository;
use App\Service\AbsenService;
use PHPUnit\Framework\TestCase;

class AbsenServiceTest extends TestCase
{
    private AbsenService $absenService;
    private AbsenRepository $absenRepository;

    protected function setUp(): void
    {

        $connection = Database::getConnection();
        $this->absenRepository = new AbsenRepository($connection);
        $this->absenService = new AbsenService($this->absenRepository);

    }

    public function testSaveAbsen()
    {
        $request = new AbsenRequest();
        $request->id_absen = "1";
        $request->username_karyawan = "budilahnamanya";
        $request->nama_karyawan = "Budi";
        $request->tanggal_absen = "2021-08-01";
        $request->jam_masuk = "08:00:00";
        $request->jam_keluar = "17:00:00";
        $request->keterangan = "Hadir";

        $response = $this->absenService->createAbsen($request);

        self::assertEquals($request->id_absen, $response->absen->id_absen);
        self::assertEquals($request->username_karyawan, $response->absen->username_karyawan);
        self::assertEquals($request->nama_karyawan, $response->absen->nama_karyawan);
        self::assertEquals($request->tanggal_absen, $response->absen->tanggal_absen);
        self::assertEquals($request->jam_masuk, $response->absen->jam_masuk);
        self::assertEquals($request->jam_keluar, $response->absen->jam_keluar);
        self::assertEquals($request->keterangan, $response->absen->keterangan);
    }

}
