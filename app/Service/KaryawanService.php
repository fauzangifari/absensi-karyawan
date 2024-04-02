<?php

namespace App\Service;

use App\Config\Database;
use App\Domain\Karyawan;
use App\Exception\ValidationException;
use App\Model\Login\UserLoginRequest;
use App\Model\Login\UserLoginResponse;
use App\Model\Register\KaryawanRegisterRequest;
use App\Model\Register\KaryawanRegisterResponse;
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

    public function login(UserLoginRequest $request): UserLoginResponse
    {
        $this->validateUserLoginRequest($request);

        $karyawan = $this->karyawanRepository->findByUsername($request->username);
        if ($karyawan == null) {
            throw new ValidationException("Username or Password is incorrect");
        }

        if (!password_verify($request->password, $karyawan->password)) {
            throw new ValidationException("Password is incorrect");
        }
        $response = new UserLoginResponse();
        $response->karyawan = $karyawan;
        return $response;
    }

    public function validateUserLoginRequest(UserLoginRequest $request): void
    {
        if($request->username == null || $request->password == null || trim($request->username) == '' || trim($request->password) == '') {
            throw new ValidationException("Username and Password can not blank");
        }
    }

    public function showAllKaryawan(): array
    {
        return $this->karyawanRepository->showAllKaryawan();
    }

    public function countKaryawan(): int
    {
        return $this->karyawanRepository->countKaryawan();
    }

    public function deleteKaryawan(string $username): void
    {
        if ($this->karyawanRepository->findByUsername($username) == null) {
            throw new ValidationException("Karyawan with Username $username not found");
        } else {
            $this->karyawanRepository->deleteKaryawan($username);
        }
    }

    public function updateKaryawan(Karyawan $karyawan): void
    {
        $this->karyawanRepository->updateKaryawan($karyawan);
    }
}