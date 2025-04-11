<?php

namespace App\Utils\Enums;

enum ContactType: string
{
    case EMAIL = 'email';
    case PHONE = 'phone';
    case WHATSAPP = 'whatsapp';
    case TELEGRAM = 'telegram';
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
