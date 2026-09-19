<?php
namespace App\Models;

readonly class Category {
    public function __construct(
        public int $id,
        public string $name,
        public string $color,
        public int $taskCount = 0, // عدد المهام المرتبطة
    ) {}
}