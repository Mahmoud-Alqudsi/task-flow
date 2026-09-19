<?php
namespace App\Repositories;

use App\Database;
use App\Models\User;
use App\Enums\UserRole;

class UserRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findByEmail(string $email): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        return $row ? $this->hydrate($row) : null;
    }

    private function hydrate(array $row): User {
        return new User(
            id: (int)$row['id'],
            name: $row['name'],
            email: $row['email'],
            password: $row['password'],
            role: UserRole::from($row['role']),
            isActive: (bool)$row['is_active'],
            lastLoginAt: $row['last_login_at'],
            createdAt: $row['created_at']
        );
    }
}