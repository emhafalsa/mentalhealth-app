<?php

namespace App\Models;

use App\Enums\ModelExperimentStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'version',
    'instrument_version_id',
    'feature_set_version',
    'status',
    'dataset_hash',
    'row_count',
    'feature_list',
    'training_config',
    'started_at',
    'finished_at',
    'error_code',
    'error_message_safe',
    'created_by',
])]
class ModelExperiment extends Model
{
    use HasUlids;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ModelExperimentStatus::class,
            'row_count' => 'integer',
            'feature_list' => 'array',
            'training_config' => 'array',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    public function scopeLatestSuccessful(Builder $query): Builder
    {
        return $query
            ->where('status', ModelExperimentStatus::Succeeded->value)
            ->latest('finished_at');
    }

    public function instrumentVersion(): BelongsTo
    {
        return $this->belongsTo(InstrumentVersion::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(ModelEvaluation::class);
    }
}
