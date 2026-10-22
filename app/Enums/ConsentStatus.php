<?php

namespace App\Enums;

enum ConsentStatus: string
{
    case Draft = 'draft';
    case Incomplete = 'incomplete';
    case PendingEthics = 'pending_ethics';
    case ReadyForReview = 'ready_for_review';
    case ApprovedForUse = 'approved_for_use';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Incomplete => 'Menunggu kelengkapan',
            self::PendingEthics => 'Menunggu verifikasi etik',
            self::ReadyForReview => 'Siap ditinjau',
            self::ApprovedForUse => 'Disetujui untuk digunakan',
        };
    }

    public function requiresCompleteText(): bool
    {
        return in_array($this, [
            self::PendingEthics,
            self::ReadyForReview,
            self::ApprovedForUse,
        ], true);
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
