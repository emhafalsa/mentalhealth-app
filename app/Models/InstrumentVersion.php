<?php

namespace App\Models;

use App\Enums\InstrumentStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'code',
    'version',
    'locale',
    'status',
    'source_reference',
    'source_url',
    'source_retrieved_at',
    'translator',
    'copyright_status',
    'verification_notes',
    'verified_at',
    'verified_by',
    'instructions',
    'item_texts',
    'response_options',
    'item_subscale_map',
    'severity_thresholds',
    'response_scale',
    'is_active',
    'effective_from',
    'created_by',
])]
class InstrumentVersion extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => InstrumentStatus::class,
            'item_texts' => 'array',
            'response_options' => 'array',
            'item_subscale_map' => 'array',
            'severity_thresholds' => 'array',
            'response_scale' => 'array',
            'is_active' => 'boolean',
            'source_retrieved_at' => 'datetime',
            'verified_at' => 'datetime',
            'effective_from' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('status', InstrumentStatus::Active->value)
            ->where('is_active', true);
    }

    /**
     * @return array<int, string>
     */
    public function orderedItemTexts(): array
    {
        $texts = $this->item_texts;

        if (! is_array($texts)) {
            return [];
        }

        $items = [];

        for ($item = 1; $item <= (int) config('dass21.item_count', 21); $item++) {
            $text = $texts[$item - 1] ?? null;

            if (! is_string($text) || blank($text)) {
                return [];
            }

            $items[$item] = trim($text);
        }

        return $items;
    }

    public function hasCompleteItemTexts(): bool
    {
        return count($this->orderedItemTexts()) === (int) config('dass21.item_count', 21);
    }

    /**
     * @return array<int, string>
     */
    public function itemTextsForEditing(): array
    {
        $texts = is_array($this->item_texts) ? $this->item_texts : [];

        return array_values(array_map(
            fn (mixed $text): string => is_string($text) ? trim($text) : '',
            array_pad($texts, (int) config('dass21.item_count', 21), ''),
        ));
    }

    /**
     * @return array<int, string>
     */
    public function responseOptions(): array
    {
        $options = $this->response_options;

        return is_array($options) && $options !== []
            ? $options
            : config('dass21.response_options', []);
    }

    public function instructionsText(): string
    {
        return filled($this->instructions)
            ? (string) $this->instructions
            : (string) config('dass21.instructions');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function screeningResults(): HasMany
    {
        return $this->hasMany(ScreeningResult::class);
    }

    public function modelExperiments(): HasMany
    {
        return $this->hasMany(ModelExperiment::class);
    }
}
