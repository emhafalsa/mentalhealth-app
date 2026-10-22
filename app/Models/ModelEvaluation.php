<?php

namespace App\Models;

use App\Enums\ClassificationTarget;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'model_experiment_id',
    'target',
    'accuracy',
    'precision_macro',
    'recall_macro',
    'f1_macro',
    'precision_weighted',
    'recall_weighted',
    'f1_weighted',
    'confusion_matrix',
    'per_class_metrics',
    'train_count',
    'test_count',
    'class_distribution',
    'artifact_path',
    'artifact_hash',
    'sklearn_version',
])]
class ModelEvaluation extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'target' => ClassificationTarget::class,
            'accuracy' => 'float',
            'precision_macro' => 'float',
            'recall_macro' => 'float',
            'f1_macro' => 'float',
            'precision_weighted' => 'float',
            'recall_weighted' => 'float',
            'f1_weighted' => 'float',
            'confusion_matrix' => 'array',
            'per_class_metrics' => 'array',
            'train_count' => 'integer',
            'test_count' => 'integer',
            'class_distribution' => 'array',
        ];
    }

    public function modelExperiment(): BelongsTo
    {
        return $this->belongsTo(ModelExperiment::class);
    }
}
