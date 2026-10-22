<?php

namespace App\Enums;

enum ClassificationTarget: string
{
    case Depresi = 'depresi';
    case Kecemasan = 'kecemasan';
    case Stres = 'stres';

    public function label(): string
    {
        return match ($this) {
            self::Depresi => 'Depresi',
            self::Kecemasan => 'Kecemasan',
            self::Stres => 'Stres',
        };
    }

    public function labelColumn(): string
    {
        return match ($this) {
            self::Depresi => 'label_depresi',
            self::Kecemasan => 'label_kecemasan',
            self::Stres => 'label_stres',
        };
    }
}
