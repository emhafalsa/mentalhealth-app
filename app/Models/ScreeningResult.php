<?php

namespace App\Models;

use App\Enums\SeverityCategory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'instrument_version_id',
    'depression_raw',
    'depression_final',
    'depression_category',
    'anxiety_raw',
    'anxiety_final',
    'anxiety_category',
    'stress_raw',
    'stress_final',
    'stress_category',
    'computed_at',
])]
class ScreeningResult extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'depression_raw' => 'integer',
            'depression_final' => 'integer',
            'depression_category' => SeverityCategory::class,
            'anxiety_raw' => 'integer',
            'anxiety_final' => 'integer',
            'anxiety_category' => SeverityCategory::class,
            'stress_raw' => 'integer',
            'stress_final' => 'integer',
            'stress_category' => SeverityCategory::class,
            'computed_at' => 'datetime',
        ];
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function instrumentVersion(): BelongsTo
    {
        return $this->belongsTo(InstrumentVersion::class);
    }
}
