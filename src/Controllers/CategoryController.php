<?php
namespace App\Controllers;

use App\Repositories\CategoryRepository;
use App\Middleware\AuthMiddleware;

class CategoryController extends BaseController {
    public function __construct() {
        AuthMiddleware::handle();
    }

    public function index(): void {
        $repo = new CategoryRepository();
        $categories = $repo->findAll();
        $this->view('categories/index', ['categories' => $categories]);
    }
}