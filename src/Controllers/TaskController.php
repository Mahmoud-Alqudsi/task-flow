<?php
namespace App\Controllers;

use App\Repositories\TaskRepository;
use App\Middleware\AuthMiddleware;

class TaskController extends BaseController {
    private TaskRepository $taskRepo;

    public function __construct() {
        AuthMiddleware::handle(); // حماية جميع مسارات المهام
        $this->taskRepo = new TaskRepository();
    }

    /**
     * قائمة المهام مع البحث المتقدم والفلترة والترقيم
     */
    public function index(): void {
        // استقبال معاملات البحث من الرابط (GET)
        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');
        $priority = trim($_GET['priority'] ?? '');
        $page = max(1, (int) ($_GET['page'] ?? 1));

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // نظام الصلاحيات:
        // المدير (admin) يرى جميع المهام
        // المستخدم العادي (user) يرى مهامه فقط
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        $userId = null;
        if ($_SESSION['user_role'] !== 'admin') {
            $userId = (int) $_SESSION['user_id'];
        }

        // تنفيذ البحث المتقدم
        $result = $this->taskRepo->advancedSearch(
            search: $search !== '' ? $search : null,
            status: $status !== '' ? $status : null,
            priority: $priority !== '' ? $priority : null,
            userId: $userId,
            page: $page,
            perPage: 10,
        );

        $this->view('tasks/index', [
            'tasks' => $result['tasks'],
            'total' => $result['total'],
            'pages' => $result['pages'],
            'currentPage' => $result['current_page'],
            'filters' => [
                'search' => $search,
                'status' => $status,
                'priority' => $priority,
            ],
            'isAdmin' => $_SESSION['user_role'] === 'admin',
        ]);
    }

    public function create(): void {
        $this->view('tasks/create');
    }

    public function store(): void {
        // منطق الحفظ سيُكمل في مرحلة لاحقة
        $this->redirect('/tasks');
    }
}