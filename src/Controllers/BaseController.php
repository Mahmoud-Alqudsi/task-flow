<?php
namespace App\Controllers;

abstract class BaseController {
    protected function view(string $name, array $data = []): void {
        extract($data);
        
        // بدء التخزين المؤقت لالتقاط محتوى الصفحة
        ob_start();
        require __DIR__ . "/../../views/{$name}.php";
        $content = ob_get_clean();
        
        // تضمين الهيكل العام
        require __DIR__ . "/../../views/layout.php";
    }

    protected function redirect(string $url): void {
        header("Location: $url");
        exit;
    }

    protected function sanitize(string $input): string {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
}