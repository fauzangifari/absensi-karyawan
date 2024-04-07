<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\App\Router;
use App\Config\Database;
use App\Controller\DashboardController;
use App\Controller\HomeController;
use App\Controller\UserController;
use App\Middleware\MustLoginMiddleware;
use App\Middleware\MustNotLoginMiddleware;

Database::getConnection('production');

Router::add('GET', '/', HomeController::class, 'index', []);

Router::add('GET', '/register', UserController::class, 'register', [MustNotLoginMiddleware::class]);
Router::add('POST', '/register', UserController::class, 'postRegister', [MustNotLoginMiddleware::class]);

Router::add('GET', '/login', UserController::class, 'login', [MustNotLoginMiddleware::class]);
Router::add('POST', '/login', UserController::class, 'postLogin', [MustNotLoginMiddleware::class]);

Router::add('GET', '/logout', UserController::class, 'logout', [MustLoginMiddleware::class]);

Router::add('GET', '/dashboard-admin', DashboardController::class, 'dashboardAdmin', [MustLoginMiddleware::class]);
Router::add('GET', '/dashboard-admin/employee', DashboardController::class, 'tableEmployee', [MustLoginMiddleware::class]);
Router::add('POST', '/dashboard-admin/employee', DashboardController::class, 'handleEmployeeAction', [MustLoginMiddleware::class]);
Router::add('GET', '/dashboard-admin/manager', DashboardController::class, 'tableManager', [MustLoginMiddleware::class]);
router::add('POST', '/dashboard-admin/manager', DashboardController::class, 'handleManagerAction', [MustLoginMiddleware::class]);

Router::add('GET', '/dashboard-karyawan', DashboardController::class, 'dashboardKaryawan', [MustLoginMiddleware::class]);
Router::add('POST', '/dashboard-karyawan', DashboardController::class, 'createAttedance', [MustLoginMiddleware::class]);

Router::add('GET', '/dashboard-manajer', DashboardController::class, 'dashboardManajer', [MustLoginMiddleware::class]);

Router::add('GET', '/dashboard-admin/attedance', DashboardController::class, 'tableAttendance', [MustLoginMiddleware::class]);

Router::run();
