<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\App\Router;
use App\Config\Database;
use App\Controller\DashboardController;
use App\Controller\HomeController;
use App\Controller\UserController;

Database::getConnection('production');

Router::add('GET', '/', HomeController::class, 'index', []);

Router::add('GET', '/register', UserController::class, 'register', []);
Router::add('POST', '/register', UserController::class, 'postRegister', []);

Router::add('GET', '/login', UserController::class, 'login', []);
Router::add('POST', '/login', UserController::class, 'postLogin', []);

Router::add('GET', '/logout', UserController::class, 'logout', []);

Router::add('GET', '/dashboard-karyawan', DashboardController::class, 'dashboardKaryawan', []);
Router::add('GET', '/dashboard-admin', DashboardController::class, 'dashboardAdmin', []);


Router::run();
