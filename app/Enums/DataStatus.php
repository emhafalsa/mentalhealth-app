<?php

namespace App\Enums;

enum DataStatus: string
{
    case Valid = 'valid';
    case Excluded = 'excluded';

    public function label(): string
    {
        return match ($this) {
            self::Valid => 'Valid',
            self::Excluded => 'Dikecualikan',
        };
    }
}
