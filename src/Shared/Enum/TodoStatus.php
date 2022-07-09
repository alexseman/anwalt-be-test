<?php

declare(strict_types=1);

namespace App\Shared\Enum;

enum TodoStatus: string
{
    case PENDING    = 'pending';
    case COMPLETED  = 'completed';

    public static function choices(): array
    {
        return array_column(self::cases(), 'value');
    }
}
