<?php

namespace App\Enums;

enum InstrumentStatus: string
{
    case Draft = 'draft';
    case PendingVerification = 'pending_verification';
    case Verified = 'verified';
    case Active = 'active';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::PendingVerification => 'Menunggu verifikasi',
            self::Verified => 'Terverifikasi',
            self::Active => 'Aktif',
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
