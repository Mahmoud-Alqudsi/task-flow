<?php
namespace App\Controllers;

use App\Repositories\TaskRepository;
use App\Middleware\AuthMiddleware;

class DashboardController extends BaseController {
    public function __construct() {
        AuthMiddleware::handle();
    }

    public function index(): void {
        $taskRepo = new TaskRepository();

        // نظام الصلاحيات: المدير يرى إحصائيات النظام كاملة
        $userId = $_SESSION['user_role'] === 'admin' ? null : (int) $_SESSION['user_id'];

        // جلب الإحصائيات من قاعدة البيانات
        $stats = $taskRepo->getStatistics($userId);

        // حساب نسبة الإنجاز
        $completionRate = $stats['total'] > 0 
            ? round(($stats['completed'] / $stats['total']) * 100) 
            : 0;

        $this->view('dashboard/index', [
            'stats' => $stats,
            'completionRate' => $completionRate,
            'isAdmin' => $_SESSION['user_role'] === 'admin',
            'userName' => $_SESSION['user_name'] ?? 'مستخدم',
        ]);
    }
}