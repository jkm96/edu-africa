<?php

namespace App\Utils\Enums;

enum AccreditationStatus: string
{
    case ACCREDITED = 'accredited';
    case UNACCREDITED = 'unaccredited';
    case UNKNOWN = 'unknown';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
