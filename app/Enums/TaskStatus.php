<?php

namespace App\Enums;

enum TaskStatus: string
{
    case PENDING = 'pending';
    case ASSIGNED = 'assigned';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Bekliyor',
            self::ASSIGNED => 'Atandı',
            self::IN_PROGRESS => 'Çalışılıyor',
            self::COMPLETED => 'Tamamlandı',
            self::CANCELLED => 'İptal Edildi',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::PENDING => 'secondary',
            self::ASSIGNED => 'info',
            self::IN_PROGRESS => 'warning',
            self::COMPLETED => 'success',
            self::CANCELLED => 'danger',
        };
    }

    public function allowedTransitions(): array
    {
        return match ($this) {
            self::PENDING => [self::ASSIGNED, self::CANCELLED],
            self::ASSIGNED => [self::IN_PROGRESS, self::CANCELLED],
            self::IN_PROGRESS => [self::COMPLETED, self::CANCELLED],
            self::COMPLETED => [],
            self::CANCELLED => [],
        };
    }
}