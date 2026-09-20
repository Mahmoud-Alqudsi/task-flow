<?php
namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Security\CsrfToken;

class AuthController extends BaseController {
    private UserRepository $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }

    public function showLogin(): void {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/tasks');
        }
        $this->view('auth/login');
    }

    public function login(): void {
        if (!CsrfToken::validate($_POST['csrf_token'] ?? null)) {
            die('خطأ أمني: رمز CSRF غير صالح.');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->userRepo->findByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            // تجديد معرف الجلسة لمنع هجمات Session Fixation
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_role'] = $user->role->value;
            $this->redirect('/tasks');
        } else {
            // رسالة عامة لمنع هجمات User Enumeration
            $_SESSION['error'] = 'البريد الإلكتروني أو كلمة المرور غير صحيحة.';
            $this->redirect('/login');
        }
    }

    public function showRegister(): void {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/tasks');
        }
        $this->view('auth/register');
    }

    public function register(): void {
        if (!CsrfToken::validate($_POST['csrf_token'] ?? null)) {
            die('خطأ أمني: رمز CSRF غير صالح.');
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($name) || empty($email) || strlen($password) < 8) {
            $_SESSION['error'] = 'يرجى التأكد من صحة البيانات (كلمة المرور 8 أحرف على الأقل).';
            $this->redirect('/register');
        }

        if ($this->userRepo->findByEmail($email)) {
            $_SESSION['error'] = 'البريد الإلكتروني مسجل مسبقاً.';
            $this->redirect('/register');
        }

        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
        $this->userRepo->create($name, $email, $hashedPassword);

        $_SESSION['success'] = 'تم إنشاء الحساب بنجاح. يرجى تسجيل الدخول.';
        $this->redirect('/login');
    }

    public function logout(): void {
        if (!CsrfToken::validate($_POST['csrf_token'] ?? null)) {
            die('خطأ أمني: رمز CSRF غير صالح.');
        }
        
        // تفريغ متغيرات الجلسة
        $_SESSION = [];
    
        // حذف كوكي الجلسة
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    
        // تدمير الجلسة
        session_destroy();
        
        $this->redirect('/login');
    }
}