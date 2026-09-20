<?php
namespace App\Controllers;

abstract class BaseController {
    protected function view(string $name, array $data = []): void {
        extract($data);
        require __DIR__ . "/../../views/{$name}.php";
    }

    protected function redirect(string $url): void {
        header("Location: $url");
        exit;
    }

    protected function sanitize(string $input): string {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
}