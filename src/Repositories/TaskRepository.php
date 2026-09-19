<?php
namespace App\Repositories;

use App\Database;
use App\Models\Task;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;

class TaskRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findAll(): array {
        $stmt = $this->db->query("
            SELECT tasks.*, users.name as user_name 
            FROM tasks 
            JOIN users ON tasks.user_id = users.id 
            ORDER BY tasks.created_at DESC
        ");
        
        return array_map([$this, 'hydrate'], $stmt->fetchAll());
    }

    private function hydrate(array $row): Task {
        return new Task(
            id: (int)$row['id'],
            userId: (int)$row['user_id'],
            title: $row['title'],
            description: $row['description'],
            status: TaskStatus::from($row['status']),
            priority: TaskPriority::from($row['priority']),
            dueDate: $row['due_date'],
            createdAt: $row['created_at'],
            userName: $row['user_name']
        );
    }
}