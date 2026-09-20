<?php
// public/index.php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use App\Router;
use App\Security\CsrfToken;
use App\Controllers\AuthController;
use App\Controllers\TaskController;
use App\Controllers\CategoryController;
use App\Controllers\DashboardController;

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// معالجة الأخطاء الشاملة (Error Handler)
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
set_exception_handler(function (Throwable $e) {
    error_log(sprintf('[%s] %s in %s:%d', date('Y-m-d H:i:s'), $e->getMessage(), $e->getFile(), $e->getLine()));
    
    http_response_code(500);
    
    // في بيئة التطوير نعرض الخطأ، في الإنتاج نخفيه
    if (($_ENV['APP_ENV'] ?? 'production') === 'development') {
        echo '<h1 style="font-family:sans-serif;">خطأ في التطبيق</h1>';
        echo '<pre style="background:#f4f4f4;padding:15px;border-radius:5px;">' . htmlspecialchars($e->getMessage()) . '</pre>';
    } else {
        echo '<h1 style="font-family:sans-serif;text-align:center;margin-top:50px;">حدث خطأ غير متوقع</h1>';
        echo '<p style="text-align:center;color:#666;">الرجاء المحاولة لاحقًا.</p>';
    }
});

// توليد توكن CSRF إن لم يكن موجوداً
CsrfToken::generate();

$router = new Router();

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// مسارات المصادقة
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
$router->get('/login', AuthController::class, 'showLogin');
$router->post('/login', AuthController::class, 'login');
$router->get('/register', AuthController::class, 'showRegister');
$router->post('/register', AuthController::class, 'register');
$router->post('/logout', AuthController::class, 'logout');

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// مسارات المهام
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
$router->get('/', TaskController::class, 'index');
$router->get('/tasks', TaskController::class, 'index');
$router->get('/tasks/create', TaskController::class, 'create');
$router->post('/tasks/store', TaskController::class, 'store');

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// مسارات التصنيفات ولوحة التحكم
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
$router->get('/categories', CategoryController::class, 'index');
$router->get('/dashboard', DashboardController::class, 'index');

// معالجة الطلب
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);