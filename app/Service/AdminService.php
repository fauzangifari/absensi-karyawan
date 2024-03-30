<?php

namespace App\Service;

use App\Exception\ValidationException;
use App\Model\Login\UserLoginRequest;
use App\Model\Login\UserLoginResponse;
use App\Repository\AdminRepository;

class AdminService
{
    private AdminRepository $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function login(UserLoginRequest $request): UserLoginResponse
    {
        $this->validateUserLoginRequest($request);

        $admin = $this->adminRepository->findByUsername($request->username);
        if ($admin == null) {
            throw new ValidationException("Admin with Username $request->username not found");
        }

        if (!password_verify($request->password, $admin->password)) {
            throw new ValidationException("Invalid Password");
        }

        $response = new UserLoginResponse();
        $response->admin = $admin;
        return $response;
    }

    public function validateUserLoginRequest(UserLoginRequest $request): void
    {
        if($request->username == null || $request->password == null || trim($request->username) == '' || trim($request->password) == '') {
            throw new ValidationException("Username and Password can not blank");
        }
    }
}