<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\App\Router;
use App\Config\Database;
use App\Controller\HomeController;
use App\Controller\KaryawanController;

Database::getConnection('production');

Router::add('GET', '/', HomeController::class, 'index', []);

Router::add('GET', '/register', KaryawanController::class, 'register', []);
Router::add('POST', '/register', KaryawanController::class, 'postRegister', []);

Router::add('GET', '/login', KaryawanController::class, 'login', []);


Router::run();
