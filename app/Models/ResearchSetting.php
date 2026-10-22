<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'research_title',
    'researcher_name',
    'institution',
    'contact_email',
    'contact_phone',
    'genz_birth_year_start',
    'genz_birth_year_end',
    'minimum_age',
    'region_definition',
    'study_start_date',
    'study_end_date',
    'age_verification_method',
    'access_mode',
    'access_code_hash',
    'ethics_confirmation_status',
    'ethics_reference',
    'retention_months',
    'deletion_procedure',
    'updated_by',
])]
class ResearchSetting extends Model
{
    /**
     * Gunakan satu baris pengaturan untuk seluruh penelitian.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'research_title' => config('research.title'),
            'minimum_age' => config('research.minimum_age', 18),
            'age_verification_method' => config('research.age_verification_method'),
        ]);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'genz_birth_year_start' => 'integer',
            'genz_birth_year_end' => 'integer',
            'minimum_age' => 'integer',
            'study_start_date' => 'date',
            'study_end_date' => 'date',
            'retention_months' => 'integer',
        ];
    }

    public function hasGenZCriteria(): bool
    {
        return $this->genz_birth_year_start !== null
            && $this->genz_birth_year_end !== null
            && $this->genz_birth_year_start <= $this->genz_birth_year_end;
    }

    public function hasOperationalGenZRange(): bool
    {
        return $this->genz_birth_year_start === (int) config('research.genz_operational_start')
            && $this->genz_birth_year_end === (int) config('research.genz_operational_end');
    }

    public function hasAccessCode(): bool
    {
        return filled($this->access_code_hash);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
