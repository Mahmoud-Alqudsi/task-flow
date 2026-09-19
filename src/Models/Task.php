<?php
namespace App\Models;

use App\Enums\TaskStatus;
use App\Enums\TaskPriority;

readonly class Task {
    public function __construct(
        public int $id,
        public int $userId,
        public string $title,
        public ?string $description,
        public TaskStatus $status,
        public TaskPriority $priority,
        public ?string $dueDate,
        public string $createdAt = '',
        public string $userName = '', // اسم صاحب المهمة (من الـ JOIN)
    ) {}

    public function isOverdue(): bool {
        return $this->dueDate && strtotime($this->dueDate) < time() && $this->status !== TaskStatus::Completed;
    }
}