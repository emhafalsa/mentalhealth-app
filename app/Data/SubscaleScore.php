<?php

namespace App\Data;

use App\Enums\SeverityCategory;

final readonly class SubscaleScore
{
    public function __construct(
        public int $raw,
        public int $final,
        public SeverityCategory $category,
    ) {}

    /**
     * @return array{raw: int, final: int, category: string}
     */
    public function toArray(): array
    {
        return [
            'raw' => $this->raw,
            'final' => $this->final,
            'category' => $this->category->value,
        ];
    }
}
