<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'item_01', 'item_02', 'item_03', 'item_04', 'item_05', 'item_06', 'item_07',
    'item_08', 'item_09', 'item_10', 'item_11', 'item_12', 'item_13', 'item_14',
    'item_15', 'item_16', 'item_17', 'item_18', 'item_19', 'item_20', 'item_21',
])]
class DassResponse extends Model
{
    public const ITEM_COUNT = 21;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        $casts = [];

        for ($item = 1; $item <= self::ITEM_COUNT; $item++) {
            $casts[self::itemColumn($item)] = 'integer';
        }

        return $casts;
    }

    public static function itemColumn(int $item): string
    {
        if ($item < 1 || $item > self::ITEM_COUNT) {
            throw new \InvalidArgumentException('Nomor butir DASS-21 harus antara 1 dan 21.');
        }

        return sprintf('item_%02d', $item);
    }

    public function valueForItem(int $item): int
    {
        return (int) $this->getAttribute(self::itemColumn($item));
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }
}
