<?php

namespace App\Service;

use App\Config\Database;
use App\Domain\Karyawan;
use App\Exception\ValidationException;
use App\Model\KaryawanRegisterRequest;
use App\Model\KaryawanRegisterResponse;
use App\Repository\KaryawanRepository;

class KaryawanService
{
    private KaryawanRepository $karyawanRepository;

    public function __construct(KaryawanRepository $karyawanRepository)
    {
        $this->karyawanRepository = $karyawanRepository;
    }

    public function register(KaryawanRegisterRequest $request): KaryawanRegisterResponse
    {
        $this->validateKaryawanRegistrationRequest($request);
        try {
            Database::begin();
            $karyawan = $this->karyawanRepository->findByUsername($request->username);
            if ($karyawan != null) {
                throw new ValidationException("Karyawan with Username Karyawan $request->username already exists");
            }

            $karyawan = new Karyawan();
            $karyawan->username = $request->username;
            $karyawan->password = password_hash($request->password, PASSWORD_BCRYPT);
            $karyawan->nama_karyawan = $request->nama_karyawan;
            $karyawan->alamat_karyawan = $request->alamat_karyawan;
            $karyawan->no_telp_karyawan = $request->no_telp_karyawan;

            $this->karyawanRepository->saveKaryawan($karyawan);

            $response = new KaryawanRegisterResponse();
            $response->karyawan = $karyawan;

            Database::commit();
            return $response;
        } catch (\Exception $exception) {
            Database::rollBack();
            throw $exception;
        }
    }

    private function validateKaryawanRegistrationRequest(KaryawanRegisterRequest $request): void
    {
        if($request->username == null || $request->password == null || $request->nama_karyawan == null || $request->alamat_karyawan == null || $request->no_telp_karyawan == null
            || trim($request->username) == '' || trim($request->password) == '' || trim($request->nama_karyawan) == '' || trim($request->alamat_karyawan) == '' || trim($request->no_telp_karyawan) == '') {
            throw new ValidationException("Username, Password, Nama Karyawan, Alamat Karyawan, dan No Telp Karyawan can not blank");
        }
    }

}