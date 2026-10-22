<?php

namespace App\Data;

final readonly class Dass21Score
{
    public function __construct(
        public SubscaleScore $depression,
        public SubscaleScore $anxiety,
        public SubscaleScore $stress,
    ) {}

    /**
     * @return array{
     *     depression: array{raw: int, final: int, category: string},
     *     anxiety: array{raw: int, final: int, category: string},
     *     stress: array{raw: int, final: int, category: string}
     * }
     */
    public function toArray(): array
    {
        return [
            'depression' => $this->depression->toArray(),
            'anxiety' => $this->anxiety->toArray(),
            'stress' => $this->stress->toArray(),
        ];
    }
}
