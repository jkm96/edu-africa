<?php

namespace App\Utils\Enums;

enum OwnershipType: string
{
    case PUBLIC = 'public';
    case PRIVATE = 'private';
    case RELIGIOUS = 'religious';
    case NGO = 'ngo';
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
