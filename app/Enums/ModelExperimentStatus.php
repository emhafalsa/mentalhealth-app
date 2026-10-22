<?php

namespace App\Enums;

enum ModelExperimentStatus: string
{
    case Queued = 'queued';
    case Running = 'running';
    case Succeeded = 'succeeded';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Queued => 'Menunggu antrean',
            self::Running => 'Sedang dilatih',
            self::Succeeded => 'Berhasil',
            self::Failed => 'Gagal',
        };
    }

    public function isFinished(): bool
    {
        return in_array($this, [self::Succeeded, self::Failed], true);
    }
}
