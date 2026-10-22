<?php

namespace Tests\Feature;

use App\Enums\ConsentStatus;
use App\Enums\InstrumentStatus;
use App\Models\ConsentVersion;
use App\Models\InstrumentVersion;
use App\Models\ResearchSetting;
use App\Models\Submission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class QuestionnaireFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_formulir_tertutup_saat_penelitian_belum_siap(): void
    {
        $this->get(route('questionnaire.start'))
            ->assertOk()
            ->assertSee('Kuesioner penelitian belum dapat diisi');
    }

    public function test_tautan_peserta_bertanda_tangan_membuka_persetujuan(): void
    {
        $this->readyResearch();

        $url = URL::temporarySignedRoute('questionnaire.access', now()->addMinutes(10));

        $this->get($url)
            ->assertRedirect(route('questionnaire.consent'));

        $this->get(route('questionnaire.consent'))
            ->assertOk()
            ->assertSee('Lembar informasi');
    }

    public function test_kode_akses_salah_ditolak(): void
    {
        $this->readyResearch(accessMode: 'restricted_group', accessCode: 'rahasia-peserta');

        $this->post(route('questionnaire.code.store'), ['access_code' => 'kode-salah'])
            ->assertSessionHasErrors('access_code');

        $this->post(route('questionnaire.code.store'), ['access_code' => 'rahasia-peserta'])
            ->assertRedirect(route('questionnaire.consent'));
    }

    public function test_alur_lengkap_menyimpan_jawaban_dan_skor(): void
    {
        $this->readyResearch();

        $accessUrl = URL::temporarySignedRoute('questionnaire.access', now()->addMinutes(10));
        $this->get($accessUrl)->assertRedirect(route('questionnaire.consent'));

        $this->post(route('questionnaire.consent.store'), ['consent' => '1'])
            ->assertRedirect(route('questionnaire.eligibility'));

        $this->post(route('questionnaire.eligibility.store'), [
            'birth_year' => 2000,
            'age_years' => 26,
            'subdistrict' => 'kertek',
            'wonosobo_resident' => '1',
        ])->assertRedirect(route('questionnaire.form'));

        $this->get(route('questionnaire.form'))
            ->assertOk()
            ->assertSee('Bagian A')
            ->assertSee('Butir uji 1');

        $nonce = session('questionnaire.nonce');

        $this->assertIsString($nonce);

        $items = [];

        foreach (range(1, 21) as $item) {
            $items[$item] = 0;
        }

        $this->post(route('questionnaire.submit'), [
            'nonce' => $nonce,
            'items' => $items,
            'factors' => [
                'education_status' => 'sma_smk',
                'employment_status' => 'pelajar_mahasiswa',
                'sleep_duration_hours' => 7.5,
                'physical_activity_days' => 3,
                'social_media_hours_per_day' => 4,
            ],
        ])->assertRedirect(route('questionnaire.complete'));

        $submission = Submission::query()->firstOrFail();

        $this->assertSame(2000, $submission->birth_year);
        $this->assertSame(26, $submission->age_at_submission);
        $this->assertSame('kertek', $submission->subdistrict);
        $this->assertTrue($submission->wonosobo_resident);
        $this->assertSame(0, $submission->dassResponse?->item_01);
        $this->assertSame('normal', $submission->screeningResult?->depression_category->value);
        $this->assertSame('sma_smk', $submission->supportingFactor?->education_status);
    }

    public function test_metode_usia_awal_memakai_tahun_lahir_dan_deklarasi_usia(): void
    {
        $this->readyResearch(ageMethod: 'birth_year_plus_age_confirmation');

        $accessUrl = URL::temporarySignedRoute('questionnaire.access', now()->addMinutes(10));
        $this->get($accessUrl)->assertRedirect(route('questionnaire.consent'));

        $this->post(route('questionnaire.consent.store'), ['consent' => '1'])
            ->assertRedirect(route('questionnaire.eligibility'));

        $this->post(route('questionnaire.eligibility.store'), [
            'birth_year' => 2000,
            'age_years' => 26,
            'subdistrict' => 'kertek',
            'wonosobo_resident' => '1',
        ])->assertRedirect(route('questionnaire.form'));

        $eligibility = session('questionnaire.eligibility');

        $this->assertSame(26, $eligibility['age_at_submission']);
        $this->assertSame('kertek', $eligibility['subdistrict']);

        $this->post(route('questionnaire.eligibility.store'), [
            'birth_year' => 2000,
            'age_years' => 50,
            'wonosobo_resident' => '1',
        ])->assertOk()
            ->assertSee('Usia yang dinyatakan tidak sesuai dengan tahun lahir.');
    }

    private function readyResearch(
        string $accessMode = 'participant_link',
        ?string $accessCode = null,
        string $ageMethod = 'age_years',
    ): ResearchSetting {
        $settings = ResearchSetting::query()->create([
            'research_title' => 'Penelitian uji',
            'genz_birth_year_start' => 1997,
            'genz_birth_year_end' => 2008,
            'minimum_age' => 18,
            'region_definition' => 'Kabupaten Wonosobo',
            'age_verification_method' => $ageMethod,
            'access_mode' => $accessMode,
            'access_code_hash' => $accessCode !== null ? Hash::make($accessCode) : null,
            'ethics_confirmation_status' => 'confirmed',
            'retention_months' => 60,
            'deletion_procedure' => 'Data dihapus setelah masa retensi.',
        ]);

        InstrumentVersion::query()->create([
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

        ConsentVersion::query()->create([
            'version' => 'test',
            'title' => 'Persetujuan uji',
            'body' => 'Teks persetujuan lengkap tanpa placeholder.',
            'status' => ConsentStatus::ApprovedForUse,
            'is_active' => true,
        ]);

        return $settings;
    }
}
