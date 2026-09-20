<?php
// public/index.php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use App\Router;
use App\Controllers\AuthController;
use App\Controllers\TaskController;
use App\Controllers\CategoryController;
use App\Controllers\DashboardController;

$router = new Router();

// مسارات المصادقة
$router->get('/login', AuthController::class, 'showLogin');
$router->post('/login', AuthController::class, 'login');
$router->post('/logout', AuthController::class, 'logout');

// مسارات المهام
$router->get('/', TaskController::class, 'index');
$router->get('/tasks', TaskController::class, 'index');
$router->get('/tasks/create', TaskController::class, 'create');
$router->post('/tasks/store', TaskController::class, 'store');

// مسارات التصنيفات
$router->get('/categories', CategoryController::class, 'index');

// لوحة التحكم
$router->get('/dashboard', DashboardController::class, 'index');

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);