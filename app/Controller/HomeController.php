<?php

namespace App\Controller;

use App\App\View;

class HomeController
{

    function index()
    {
        View::render('Home/index', [
            'title' => 'Absensi Karyawan'
        ]);
    }

}