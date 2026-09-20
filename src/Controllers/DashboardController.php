<?php
namespace App\Controllers;

use App\Middleware\AuthMiddleware;

class DashboardController extends BaseController {
    public function __construct() {
        AuthMiddleware::handle();
    }

    public function index(): void {
        $this->view('dashboard/index');
    }
}