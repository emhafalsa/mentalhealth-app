<?php

namespace Tests\Feature;

use App\Enums\ConsentStatus;
use App\Enums\InstrumentStatus;
use App\Models\ConsentVersion;
use App\Models\InstrumentVersion;
use App\Models\ResearchSetting;
use App\Services\ResearchReadinessService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResearchReadinessTest extends TestCase
{
    use RefreshDatabase;

    public function test_semua_gerbang_terpenuhi(): void
    {
        $settings = $this->readySettings();
        $this->activeInstrument();
        $this->activeConsent();

        $service = new ResearchReadinessService;
        $checks = $service->checks($settings);

        $this->assertTrue($service->isReady($checks), implode(', ', $service->blockers($checks)));
        $this->assertSame([], $service->blockers($checks));
    }

    public function test_instrumen_dan_consent_harus_aktif(): void
    {
        $settings = $this->readySettings();

        $service = new ResearchReadinessService;
        $checks = $service->checks($settings);

        $this->assertFalse($checks['instrument']);
        $this->assertFalse($checks['consent']);
        $this->assertFalse($service->isReady($checks));
    }

    public function test_placeholder_consent_menahan_aktivasi(): void
    {
        $settings = $this->readySettings();
        $this->activeInstrument();
        $this->activeConsent('Saya [NAMA PENELITI] meminta persetujuan.');

        $service = new ResearchReadinessService;
        $checks = $service->checks($settings);

        $this->assertTrue($checks['consent']);
        $this->assertFalse($checks['consent_placeholders']);
        $this->assertFalse($service->isReady($checks));
        $this->assertContains('Teks persetujuan masih memuat placeholder', $service->blockers($checks));
    }

    public function test_rentang_genz_harus_1997_sampai_2008(): void
    {
        $settings = $this->readySettings(['genz_birth_year_end' => 2012]);
        $this->activeInstrument();
        $this->activeConsent();

        $service = new ResearchReadinessService;
        $checks = $service->checks($settings);

        $this->assertFalse($checks['genz']);
        $this->assertFalse($service->isReady($checks));
    }

    public function test_formulir_tidak_boleh_memakai_mode_akses_publik(): void
    {
        $settings = $this->readySettings(['access_mode' => 'public']);
        $this->activeInstrument();
        $this->activeConsent();

        $service = new ResearchReadinessService;
        $checks = $service->checks($settings);

        $this->assertFalse($checks['access']);
        $this->assertFalse($service->isReady($checks));
    }

    public function test_mspss_yang_diaktifkan_menahan_aktivasi(): void
    {
        config()->set('research.features.social_support_score.active', true);

        $settings = $this->readySettings();
        $this->activeInstrument();
        $this->activeConsent();

        $service = new ResearchReadinessService;
        $checks = $service->checks($settings);

        $this->assertFalse($checks['mspss']);
        $this->assertFalse($service->isReady($checks));
    }

    public function test_mspss_yang_dijadikan_fitur_model_menahan_aktivasi(): void
    {
        config()->set('research.features.social_support_score.model_feature', true);

        $settings = $this->readySettings();
        $this->activeInstrument();
        $this->activeConsent();

        $service = new ResearchReadinessService;
        $checks = $service->checks($settings);

        $this->assertFalse($checks['mspss']);
        $this->assertFalse($service->isReady($checks));
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function readySettings(array $overrides = []): ResearchSetting
    {
        return ResearchSetting::query()->create(array_merge([
            'research_title' => 'Penelitian uji',
            'genz_birth_year_start' => 1997,
            'genz_birth_year_end' => 2008,
            'minimum_age' => 18,
            'region_definition' => 'Kabupaten Wonosobo',
            'age_verification_method' => 'age_years',
            'access_mode' => 'participant_link',
            'ethics_confirmation_status' => 'confirmed',
            'retention_months' => 60,
            'deletion_procedure' => 'Data dihapus setelah masa retensi.',
        ], $overrides));
    }

    private function activeInstrument(): InstrumentVersion
    {
        return InstrumentVersion::query()->create([
            'code' => 'dass21',
            'version' => 'test',
            'locale' => 'id',
            'status' => InstrumentStatus::Active,
            'source_reference' => 'Sumber uji',
            'instructions' => 'Instruksi uji.',
            'item_texts' => collect(range(1, 21))->map(fn (int $item): string => "Butir uji {$item}")->all(),
            'response_options' => config('dass21.response_options'),
            'item_subscale_map' => config('dass21.item_subscale_map'),
            'severity_thresholds' => config('dass21.severity_thresholds'),
            'response_scale' => config('dass21.response_values'),
            'is_active' => true,
        ]);
    }

    private function activeConsent(string $body = 'Teks persetujuan lengkap tanpa placeholder.'): ConsentVersion
    {
        return ConsentVersion::query()->create([
            'version' => 'test',
            'title' => 'Persetujuan uji',
            'body' => $body,
            'status' => ConsentStatus::ApprovedForUse,
            'is_active' => true,
        ]);
    }
}
