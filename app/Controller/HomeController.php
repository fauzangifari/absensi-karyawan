<?php

namespace App\Controller;

use App\App\View;

class HomeController
{

    function index()
    {
        View::redirect('/login');
    }

}