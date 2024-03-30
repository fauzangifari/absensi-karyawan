<?php

namespace App\Model\Login;

use App\Domain\Admin;
use App\Domain\Karyawan;

class UserLoginResponse
{
    public Karyawan $karyawan;
    public Admin $admin;
}