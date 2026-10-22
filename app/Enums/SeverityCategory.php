<?php

namespace App\Enums;

enum SeverityCategory: string
{
    case Normal = 'normal';
    case Ringan = 'ringan';
    case Sedang = 'sedang';
    case Berat = 'berat';
    case SangatBerat = 'sangat_berat';

    public function label(): string
    {
        return match ($this) {
            self::Normal => 'Normal',
            self::Ringan => 'Ringan',
            self::Sedang => 'Sedang',
            self::Berat => 'Berat',
            self::SangatBerat => 'Sangat berat',
        };
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
