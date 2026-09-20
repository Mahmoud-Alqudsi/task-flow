<?php
namespace App\Controllers;

use App\Repositories\TaskRepository;
use App\Middleware\AuthMiddleware;

class TaskController extends BaseController {
    private TaskRepository $taskRepo;

    public function __construct() {
        AuthMiddleware::handle(); // حماية مسارات المهام
        $this->taskRepo = new TaskRepository();
    }

    public function index(): void {
        $tasks = $this->taskRepo->findAll();
        $this->view('tasks/index', ['tasks' => $tasks]);
    }

    public function create(): void {
        $this->view('tasks/create');
    }

    public function store(): void {
        // منطق الحفظ سيأتي لاحقاً
    }
}