<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case CHIEF = 'chief';
    case STAFF = 'staff';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Sistem Yöneticisi',
            self::MANAGER => 'Müdür',
            self::CHIEF => 'Şef',
            self::STAFF => 'Saha Personeli',
        };
    }
}