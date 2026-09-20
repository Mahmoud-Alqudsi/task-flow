<?php
namespace App\Controllers;

use App\Repositories\UserRepository;

class AuthController extends BaseController {
    private UserRepository $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }

    public function showLogin(): void {
        $this->view('auth/login');
    }

    public function login(): void {
        // منطق تسجيل الدخول سيأتي في مرحلة الأمان
        echo "تم استلام طلب الدخول";
    }

    public function logout(): void {
        session_destroy();
        $this->redirect('/login');
    }
}