<?php

namespace App\Service;

use App\Config\Database;
use App\Domain\Absen;
use App\Exception\ValidationException;
use App\Model\Absen\AbsenRequest;
use App\Model\Absen\AbsenResponse;
use App\Repository\AbsenRepository;

class AbsenService
{
    private AbsenRepository $absenRepository;

    public function __construct(AbsenRepository $absenRepository)
    {
        $this->absenRepository = $absenRepository;
    }

    public function createAbsen(AbsenRequest $request): AbsenResponse
    {
        try {
            Database::begin();
            $absen = $this->absenRepository->checkEmployeeAbsen($request->username_karyawan, $request->tanggal_absen);
            if ($absen != null) {
                throw new \Exception("Absen for Employee $request->username_karyawan on $request->tanggal_absen already exists");
            }

            $absen = new Absen();
            $absen->id_absen = $request->id_absen;
            $absen->username_karyawan = $request->username_karyawan;
            $absen->nama_karyawan = $request->nama_karyawan;
            $absen->tanggal_absen = $request->tanggal_absen;
            $absen->jam_masuk = $request->jam_masuk;
            $absen->jam_keluar = $request->jam_keluar;
            $absen->keterangan = $request->keterangan;
            $absen->alasan = $request->alasan;
            $absen->file = $request->file;

            $this->absenRepository->saveAbsen($absen);

            $response = new AbsenResponse();
            $response->absen = $absen;

            Database::commit();
            return $response;

        } catch (\Exception $exception) {
            Database::rollBack();
            throw $exception;
        }
    }

    public function showAllAttedance(): array
    {
        return $this->absenRepository->showAllAttedance();
    }

    public function showAllAttedanceByDate(string $date): array
    {
        return $this->absenRepository->showAllAttedanceByDate($date);
    }

    public function getAttedanceCountByDate(string $date): int
    {
        return $this->absenRepository->getAttedanceCountByDate($date);
    }
}