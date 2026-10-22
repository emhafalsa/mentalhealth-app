<?php

namespace App\Models;

use App\Enums\DataStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'birth_year',
    'age_at_submission',
    'subdistrict',
    'wonosobo_resident',
    'eligible',
    'consent_version_id',
    'consent_accepted_at',
    'data_status',
    'exclusion_reason',
    'submitted_at',
])]
class Submission extends Model
{
    use HasUlids;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birth_year' => 'integer',
            'age_at_submission' => 'integer',
            'wonosobo_resident' => 'boolean',
            'eligible' => 'boolean',
            'consent_accepted_at' => 'datetime',
            'data_status' => DataStatus::class,
            'submitted_at' => 'datetime',
        ];
    }

    public function scopeIncluded(Builder $query): Builder
    {
        return $query->where('data_status', DataStatus::Valid->value);
    }

    public function subdistrictLabel(): ?string
    {
        if (blank($this->subdistrict)) {
            return null;
        }

        return config('research.subdistricts.'.$this->subdistrict, $this->subdistrict);
    }

    public function consentVersion(): BelongsTo
    {
        return $this->belongsTo(ConsentVersion::class);
    }

    public function dassResponse(): HasOne
    {
        return $this->hasOne(DassResponse::class);
    }

    public function supportingFactor(): HasOne
    {
        return $this->hasOne(SupportingFactor::class);
    }

    public function screeningResult(): HasOne
    {
        return $this->hasOne(ScreeningResult::class);
    }
}
