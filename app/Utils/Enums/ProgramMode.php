<?php

namespace App\Utils\Enums;

enum ProgramMode: string
{
    case FULL_TIME = 'full_time';
    case PART_TIME = 'part_time';
    case ONLINE = 'online';
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
