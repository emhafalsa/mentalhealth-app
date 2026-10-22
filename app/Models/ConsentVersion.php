<?php

namespace App\Models;

use App\Enums\ConsentStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'version',
    'title',
    'body',
    'status',
    'verified_at',
    'verified_by',
    'effective_from',
    'is_active',
    'created_by',
])]
class ConsentVersion extends Model
{
    protected static function booted(): void
    {
        // Hash membantu membuktikan teks persetujuan yang disetujui responden.
        static::saving(function (self $consent): void {
            if ($consent->isDirty('body')) {
                $consent->content_hash = hash('sha256', (string) $consent->body);
            }
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ConsentStatus::class,
            'verified_at' => 'datetime',
            'effective_from' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('status', ConsentStatus::ApprovedForUse->value)
            ->where('is_active', true);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
