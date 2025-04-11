<?php

namespace App\Utils\Enums;

enum ProgramLevel: string
{
    case CERTIFICATE = 'certificate';
    case DIPLOMA = 'diploma';
    case DEGREE = 'degree';
    case MASTERS = 'masters';
    case PHD = 'phd';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
