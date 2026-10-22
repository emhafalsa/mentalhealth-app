<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'education_status',
    'employment_status',
    'sleep_duration_hours',
    'physical_activity_days',
    'social_media_hours_per_day',
    'social_support_score',
])]
class SupportingFactor extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sleep_duration_hours' => 'float',
            'physical_activity_days' => 'integer',
            'social_media_hours_per_day' => 'float',
            'social_support_score' => 'integer',
        ];
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }
}
