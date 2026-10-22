<?php

namespace App\Services;

use App\Data\Dass21Score;
use App\Data\SubscaleScore;
use App\Enums\SeverityCategory;
use InvalidArgumentException;
use LogicException;

final class Dass21Scorer
{
    /**
     * @param  array<int|string, int|string>  $answers
     */
    public function score(array $answers): Dass21Score
    {
        $itemCount = (int) config('dass21.item_count', 21);
        $multiplier = (int) config('dass21.score_multiplier', 2);
        $normalized = $this->normalizeAnswers($answers, $itemCount);

        if ($multiplier < 1) {
            throw new LogicException('Pengali skor DASS-21 harus lebih dari nol.');
        }

        $scores = [];

        foreach (['depression', 'anxiety', 'stress'] as $subscale) {
            $items = config("dass21.item_subscale_map.{$subscale}");

            if (! is_array($items) || $items === []) {
                throw new LogicException("Pemetaan butir DASS-21 untuk {$subscale} tidak tersedia.");
            }

            $raw = 0;

            foreach ($items as $item) {
                if (! array_key_exists($item, $normalized)) {
                    throw new LogicException("Butir DASS-21 nomor {$item} tidak ditemukan.");
                }

                $raw += $normalized[$item];
            }

            $final = $raw * $multiplier;

            $scores[$subscale] = new SubscaleScore(
                raw: $raw,
                final: $final,
                category: $this->categoryFor($subscale, $final),
            );
        }

        return new Dass21Score(
            depression: $scores['depression'],
            anxiety: $scores['anxiety'],
            stress: $scores['stress'],
        );
    }

    /**
     * @param  array<int|string, int|string>  $answers
     * @return array<int, int>
     */
    private function normalizeAnswers(array $answers, int $itemCount): array
    {
        $normalized = [];

        foreach ($answers as $key => $value) {
            if (is_int($key)) {
                $item = $key;
            } elseif (is_string($key) && ctype_digit($key)) {
                $item = (int) $key;
            } else {
                throw new InvalidArgumentException('Kunci jawaban DASS-21 harus berupa nomor butir.');
            }

            if ($item < 1 || $item > $itemCount) {
                throw new InvalidArgumentException("Nomor butir DASS-21 harus antara 1 dan {$itemCount}.");
            }

            if (array_key_exists($item, $normalized)) {
                throw new InvalidArgumentException("Butir DASS-21 nomor {$item} dikirim lebih dari sekali.");
            }

            if (! is_int($value) && ! (is_string($value) && ctype_digit($value))) {
                throw new InvalidArgumentException("Jawaban butir DASS-21 nomor {$item} harus berupa bilangan bulat 0-3.");
            }

            $normalized[$item] = (int) $value;
        }

        if (count($normalized) !== $itemCount) {
            throw new InvalidArgumentException("DASS-21 membutuhkan tepat {$itemCount} jawaban.");
        }

        for ($item = 1; $item <= $itemCount; $item++) {
            if (! array_key_exists($item, $normalized)) {
                throw new InvalidArgumentException("Jawaban butir DASS-21 nomor {$item} belum diisi.");
            }
        }

        foreach ($normalized as $item => $value) {
            if ($value < 0 || $value > 3) {
                throw new InvalidArgumentException("Jawaban butir DASS-21 nomor {$item} harus antara 0 dan 3.");
            }
        }

        ksort($normalized);

        return $normalized;
    }

    private function categoryFor(string $subscale, int $finalScore): SeverityCategory
    {
        $thresholds = config("dass21.severity_thresholds.{$subscale}");

        if (! is_array($thresholds) || $thresholds === []) {
            throw new LogicException("Ambang kategori DASS-21 untuk {$subscale} tidak tersedia.");
        }

        foreach ($thresholds as $threshold) {
            if ($finalScore < $threshold['min']) {
                continue;
            }

            if ($threshold['max'] === null || $finalScore <= $threshold['max']) {
                return SeverityCategory::from($threshold['category']);
            }
        }

        throw new LogicException("Skor akhir {$subscale} berada di luar ambang kategori yang tersedia.");
    }
}
