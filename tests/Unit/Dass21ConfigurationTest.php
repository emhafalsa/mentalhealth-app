<?php

namespace Tests\Unit;

use App\Enums\SeverityCategory;
use Tests\TestCase;

class Dass21ConfigurationTest extends TestCase
{
    public function test_pemetaan_butir_mencakup_1_sampai_21_tepat_sekali(): void
    {
        $map = config('dass21.item_subscale_map');
        $items = array_merge(...array_values($map));
        sort($items);

        $this->assertSame(range(1, 21), $items);
    }

    public function test_setiap_subskala_memiliki_tujuh_butir(): void
    {
        foreach (config('dass21.item_subscale_map') as $items) {
            $this->assertCount(7, $items);
        }
    }

    public function test_dass21_memakai_21_butir_dan_pengali_dua(): void
    {
        $this->assertSame(21, config('dass21.item_count'));
        $this->assertSame(2, config('dass21.score_multiplier'));
    }

    public function test_ambang_kategori_kontinu_dan_memakai_enum_yang_sah(): void
    {
        foreach (config('dass21.severity_thresholds') as $thresholds) {
            $expectedMin = 0;
            $categories = [];

            foreach ($thresholds as $threshold) {
                $this->assertSame($expectedMin, $threshold['min']);
                $this->assertTrue(
                    $threshold['max'] === null || $threshold['max'] >= $threshold['min']
                );

                $categories[] = SeverityCategory::from($threshold['category']);
                $expectedMin = $threshold['max'] === null ? null : $threshold['max'] + 1;
            }

            $this->assertContains(SeverityCategory::Normal, $categories);
            $this->assertContains(SeverityCategory::SangatBerat, $categories);
            $this->assertNull($expectedMin, 'Kategori terakhir harus terbuka tanpa batas atas.');
        }
    }

    public function test_kolom_dass_dan_target_dilarang_masuk_fitur_model(): void
    {
        $forbidden = config('research.forbidden_model_columns');

        foreach (range(1, 21) as $item) {
            $this->assertContains(sprintf('item_%02d', $item), $forbidden);
        }

        foreach (['depression_final', 'anxiety_final', 'stress_final', 'label_depresi'] as $column) {
            $this->assertContains($column, $forbidden);
        }
    }
}
