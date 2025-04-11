<?php

namespace App\Utils\Enums;

enum InstitutionType: string
{
    case UNIVERSITY = 'university';
    case COLLEGE = 'college';
    case HIGH_SCHOOL = 'high_school';
    case VOCATIONAL = 'vocational';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
