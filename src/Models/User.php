<?php
namespace App\Models;

use App\Enums\UserRole;

readonly class User {
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password,
        public UserRole $role,
        public bool $isActive,
        public ?string $lastLoginAt = null,
        public string $createdAt = '',
    ) {}

    public function isAdmin(): bool {
        return $this->role->isAdmin();
    }
}