<?php
namespace App\Repositories;

use App\Database;
use App\Models\Category;

class CategoryRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findAll(): array {
        $stmt = $this->db->query("
            SELECT categories.*, COUNT(task_category.task_id) as task_count
            FROM categories
            LEFT JOIN task_category ON categories.id = task_category.category_id
            GROUP BY categories.id
        ");
        
        return array_map(fn($row) => new Category(
            id: (int)$row['id'],
            name: $row['name'],
            color: $row['color'],
            taskCount: (int)$row['task_count']
        ), $stmt->fetchAll());
    }
}