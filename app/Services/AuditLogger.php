<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

final class AuditLogger
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function record(string $action, Model $subject, array $metadata = []): void
    {
        AuditLog::query()->create([
            'user_id' => auth()->id(),
            'action' => $action,
            'auditable_type' => $subject->getMorphClass(),
            'auditable_id' => (string) $subject->getKey(),
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
