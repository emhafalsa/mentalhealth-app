<?php

namespace Tests\Unit;

use App\Enums\SeverityCategory;
use App\Services\Dass21Scorer;
use InvalidArgumentException;
use Tests\TestCase;

class Dass21ScorerTest extends TestCase
{
    public function test_skor_mentah_dijumlahkan_per_subskala_dan_dikalikan_dua(): void
    {
        $score = (new Dass21Scorer)->score($this->answers(
            depression: 1,
            anxiety: 2,
            stress: 3,
        ));

        $this->assertSame(7, $score->depression->raw);
        $this->assertSame(14, $score->depression->final);
        $this->assertSame(SeverityCategory::Sedang, $score->depression->category);

        $this->assertSame(14, $score->anxiety->raw);
        $this->assertSame(28, $score->anxiety->final);
        $this->assertSame(SeverityCategory::SangatBerat, $score->anxiety->category);

        $this->assertSame(21, $score->stress->raw);
        $this->assertSame(42, $score->stress->final);
        $this->assertSame(SeverityCategory::SangatBerat, $score->stress->category);
    }

    public function test_semua_jawaban_nol_berada_di_kategori_normal(): void
    {
        $score = (new Dass21Scorer)->score($this->answers());

        foreach ([$score->depression, $score->anxiety, $score->stress] as $subscale) {
            $this->assertSame(0, $subscale->raw);
            $this->assertSame(0, $subscale->final);
            $this->assertSame(SeverityCategory::Normal, $subscale->category);
        }
    }

    public function test_batas_kategori_dihitung_dari_skor_akhir(): void
    {
        $cases = [
            5 => SeverityCategory::Ringan,
            7 => SeverityCategory::Sedang,
            10 => SeverityCategory::Sedang,
            11 => SeverityCategory::Berat,
            14 => SeverityCategory::SangatBerat,
        ];

        foreach ($cases as $raw => $category) {
            $score = (new Dass21Scorer)->score($this->depressionAnswers($raw));

            $this->assertSame($raw, $score->depression->raw);
            $this->assertSame($raw * 2, $score->depression->final);
            $this->assertSame($category, $score->depression->category);
        }
    }

    public function test_jawaban_berupa_string_angka_diterima(): void
    {
        $answers = $this->answers();
        $answers[1] = '3';

        $score = (new Dass21Scorer)->score($answers);

        $this->assertSame(3, $score->stress->raw);
        $this->assertSame(6, $score->stress->final);
    }

    public function test_jumlah_jawaban_kurang_dari_21_ditolak(): void
    {
        $answers = $this->answers();
        unset($answers[21]);

        $this->expectException(InvalidArgumentException::class);

        (new Dass21Scorer)->score($answers);
    }

    public function test_nomor_butir_di_luar_rentang_ditolak(): void
    {
        $answers = $this->answers();
        $answers[22] = 0;

        $this->expectException(InvalidArgumentException::class);

        (new Dass21Scorer)->score($answers);
    }

    public function test_nilai_jawaban_di_luar_0_sampai_3_ditolak(): void
    {
        $answers = $this->answers();
        $answers[1] = 4;

        $this->expectException(InvalidArgumentException::class);

        (new Dass21Scorer)->score($answers);
    }

    public function test_nilai_jawaban_negatif_ditolak(): void
    {
        $answers = $this->answers();
        $answers[1] = -1;

        $this->expectException(InvalidArgumentException::class);

        (new Dass21Scorer)->score($answers);
    }

    public function test_nilai_jawaban_bukan_bilangan_bulat_ditolak(): void
    {
        $answers = $this->answers();
        $answers[1] = 1.5;

        $this->expectException(InvalidArgumentException::class);

        (new Dass21Scorer)->score($answers);
    }

    public function test_kunci_butir_yang_bukan_angka_ditolak(): void
    {
        $answers = $this->answers();
        $answers['satu'] = 0;

        $this->expectException(InvalidArgumentException::class);

        (new Dass21Scorer)->score($answers);
    }

    public function test_input_tidak_diubah(): void
    {
        $answers = $this->answers(depression: 2);
        $original = $answers;

        (new Dass21Scorer)->score($answers);

        $this->assertSame($original, $answers);
    }

    /**
     * @return array<int, int>
     */
    private function answers(int $depression = 0, int $anxiety = 0, int $stress = 0): array
    {
        $answers = array_fill(1, 21, 0);

        foreach (config('dass21.item_subscale_map.depression') as $item) {
            $answers[$item] = $depression;
        }

        foreach (config('dass21.item_subscale_map.anxiety') as $item) {
            $answers[$item] = $anxiety;
        }

        foreach (config('dass21.item_subscale_map.stress') as $item) {
            $answers[$item] = $stress;
        }

        return $answers;
    }

    /**
     * @return array<int, int>
     */
    private function depressionAnswers(int $rawScore): array
    {
        $answers = $this->answers();
        $remaining = $rawScore;

        foreach (config('dass21.item_subscale_map.depression') as $item) {
            $value = min(3, $remaining);
            $answers[$item] = $value;
            $remaining -= $value;
        }

        $this->assertSame(0, $remaining);

        return $answers;
    }
}
