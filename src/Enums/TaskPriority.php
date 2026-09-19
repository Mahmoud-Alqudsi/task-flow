<?php
namespace App\Enums;

enum TaskPriority: string {
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
    case Urgent = 'urgent';

    public function label(): string {
        return match($this) {
            self::Low => 'منخفضة',
            self::Medium => 'متوسطة',
            self::High => 'عالية',
            self::Urgent => 'عاجلة',
        };
    }
}