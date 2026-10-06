<?php

namespace App\Enums;

enum TaskPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case URGENT = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Düşük',
            self::MEDIUM => 'Orta',
            self::HIGH => 'Yüksek',
            self::URGENT => 'Acil',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::LOW => 'light',
            self::MEDIUM => 'info',
            self::HIGH => 'warning',
            self::URGENT => 'danger',
        };
    }
}