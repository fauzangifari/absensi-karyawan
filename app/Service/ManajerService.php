<?php

namespace App\Service;

use App\Config\Database;
use App\Domain\Manajer;
use App\Exception\ValidationException;
use App\Model\Login\UserLoginRequest;
use App\Model\Login\UserLoginResponse;
use App\Model\Register\ManajerRegisterRequest;
use App\Model\Register\ManajerRegisterResponse;
use App\Repository\ManajerRepository;

class ManajerService
{
    private ManajerRepository $manajerRepository;

    public function __construct(ManajerRepository $manajerRepository)
    {
        $this->manajerRepository = $manajerRepository;
    }

    public function register(ManajerRegisterRequest $request): ManajerRegisterResponse
    {
        $this->validateManajerRegistrationRequest($request);
        try {
            Database::begin();
            $manajer = $this->manajerRepository->findByUsername($request->username);
            if ($manajer != null) {
                throw new ValidationException("Manajer with Username $request->username already exists");
            }

            $manajer = new Manajer();
            $manajer->username = $request->username;
            $manajer->password = password_hash($request->password, PASSWORD_BCRYPT);
            $manajer->nama_manajer = $request->nama_manajer;
            $manajer->alamat_manajer = $request->alamat_manajer;
            $manajer->no_telp_manajer = $request->no_telp_manajer;

            $this->manajerRepository->saveManajer($manajer);

            $response = new ManajerRegisterResponse();
            $response->manajer = $manajer;

            Database::commit();
            return $response;
        } catch (\Exception $exception) {
            Database::rollback();
            throw $exception;
        }
    }
    
    public function login(UserLoginRequest $request): UserLoginResponse
    {
        $this->validateUserLoginRequest($request);
        
        $manajer = $this->manajerRepository->findByUsername($request->username);
        if ($manajer == null) {
            throw new ValidationException("Manajer with Username $request->username not found");
        }
        
        if (!password_verify($request->password, $manajer->password)) {
            throw new ValidationException("Invalid Password");
        }
        
        $response = new UserLoginResponse();
        $response->manajer = $manajer;
        return $response;
    }

    public function validateUserLoginRequest(UserLoginRequest $request): void
    {
        if($request->username == null || $request->password == null || trim($request->username) == '' || trim($request->password) == '') {
            throw new ValidationException("Username and Password can not blank");
        }
    }

    public function showAllManajer(): array
    {
        return $this->manajerRepository->showAllManajer();
    }

    public function countManajer(): int
    {
        return $this->manajerRepository->countManajer();
    }

    public function deleteManajer(string $username): void
    {
        if ($this->manajerRepository->findByUsername($username) == null) {
            throw new ValidationException("Manajer with Username $username not found");
        } else {
            $this->manajerRepository->deleteManajer($username);
        }
    }

    public function updateManajer(Manajer $manajer): void
    {
        $this->manajerRepository->updateManajer($manajer);
    }

    private function validateManajerRegistrationRequest(ManajerRegisterRequest $request)
    {
        if($request->username == null || $request->password == null || $request->nama_manajer == null
            || $request->alamat_manajer == null || $request->no_telp_manajer == null
            || trim($request->username) == '' || trim($request->password) == ''
            || trim($request->nama_manajer) == '' || trim($request->alamat_manajer) == ''
            || trim($request->no_telp_manajer) == '') {
            throw new ValidationException("Username, Password, Nama Manajer, Alamat Manajer, No. Telepon Manajer can not be blank");
        }
    }
}