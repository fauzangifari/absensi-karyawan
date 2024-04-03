<?php

namespace Repository;

use App\Config\Database;
use App\Domain\Absen;
use App\Repository\AbsenRepository;
use PHPUnit\Framework\TestCase;

class AbsenRepositoryTest extends TestCase
{
    private AbsenRepository $absenRepository;

    protected function setUp(): void
    {
        $this->absenRepository = new AbsenRepository(Database::getConnection());
        $this->absenRepository->deleteAll();
    }

    public function testSaveSuccesAttedance()
    {
        $absen = new Absen();
        $absen->id_absen = "1";
        $absen->username_karyawan = "fauzan";
        $absen->nama_karyawan = "fauzan gifari";
        $absen->tanggal_absen = "2021-08-01";
        $absen->jam_masuk = "08:00:00";
        $absen->jam_keluar = "17:00:00";
        $absen->keterangan = "Hadir";
        $this->absenRepository->saveAbsen($absen);

        $result = $this->absenRepository->checkEmployeeAbsen($absen->username_karyawan, $absen->tanggal_absen);

        self::assertEquals($absen->id_absen, $result->id_absen);
        self::assertEquals($absen->username_karyawan, $result->username_karyawan);
        self::assertEquals($absen->nama_karyawan, $result->nama_karyawan);
        self::assertEquals($absen->tanggal_absen, $result->tanggal_absen);
        self::assertEquals($absen->jam_masuk, $result->jam_masuk);
        self::assertEquals($absen->jam_keluar, $result->jam_keluar);
        self::assertEquals($absen->keterangan, $result->keterangan);
    }

    public function testFindByIdNotFound()
    {
        $result = $this->absenRepository->checkEmployeeAbsen("notfound", "2021-08-01");
        self::assertNull($result);
    }

    public function testCheckEmployeeAbsenNotFound()
    {
        $result = $this->absenRepository->checkEmployeeAbsen("fauzan", "2021-08-01");
        self::assertNull($result);
    }

    public function testCheckEmployeeAbsen()
    {
        $absen = new Absen();
        $absen->id_absen = "1";
        $absen->username_karyawan = "fauzan";
        $absen->nama_karyawan = "fauzan gifari";
        $absen->tanggal_absen = "2021-08-01";
        $absen->jam_masuk = "08:00:00";
        $absen->jam_keluar = "17:00:00";
        $absen->keterangan = "Hadir";
        $this->absenRepository->saveAbsen($absen);

        $result = $this->absenRepository->checkEmployeeAbsen($absen->username_karyawan, $absen->tanggal_absen);

        self::assertEquals($absen->id_absen, $result->id_absen);
        self::assertEquals($absen->username_karyawan, $result->username_karyawan);
        self::assertEquals($absen->nama_karyawan, $result->nama_karyawan);
        self::assertEquals($absen->tanggal_absen, $result->tanggal_absen);
        self::assertEquals($absen->jam_masuk, $result->jam_masuk);
        self::assertEquals($absen->jam_keluar, $result->jam_keluar);
        self::assertEquals($absen->keterangan, $result->keterangan);
    }
}
