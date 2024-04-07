<?php

namespace App\Model\Login;

use App\Domain\Admin;
use App\Domain\Karyawan;
use App\Domain\Manajer;

class UserLoginResponse
{
    public Karyawan $karyawan;
    public Admin $admin;
    public Manajer $manajer;
}