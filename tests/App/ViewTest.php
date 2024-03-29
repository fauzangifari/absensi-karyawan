<?php

namespace App;

use App\App\View;
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testRender()
    {
        View::render('Home/index', [
            'Absensi Karyawan'
        ]);

        $this->expectOutputRegex('[Absensi Karyawan]');
        $this->expectOutputRegex('[html]');
        $this->expectOutputRegex('[head]');
        $this->expectOutputRegex('[body]');
    }
}
