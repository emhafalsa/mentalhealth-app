<?php

namespace Tests\Feature;

use App\Enums\ConsentStatus;
use App\Enums\DataStatus;
use App\Enums\SeverityCategory;
use App\Models\ConsentVersion;
use App\Models\DassResponse;
use App\Models\InstrumentVersion;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_data_responden_hanya_dapat_diakses_admin(): void
    {
        $this->get(route('admin.submissions.index'))->assertRedirect('/login');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.submissions.index'))
            ->assertForbidden();
    }

    public function test_admin_melihat_detail_dan_mengekspor_dataset_csv(): void
    {
        $admin = User::factory()->admin()->create();
        $submission = $this->submission();

        $this->actingAs($admin)
            ->get(route('admin.submissions.index'))
            ->assertOk()
            ->assertSee('Kiriman responden')
            ->assertSee('Kertek')
            ->assertSee('Normal');

        $this->actingAs($admin)
            ->get(route('admin.submissions.show', $submission))
            ->assertOk()
            ->assertSee('Hasil DASS-21')
            ->assertSee('Kertek')
            ->assertSee('sma_smk')
            ->assertSee('7.5');

        $response = $this->actingAs($admin)
            ->get(route('admin.submissions.export'));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');

        $csv = $response->streamedContent();

        $this->assertStringContainsString('age_years,subdistrict,education_status,employment_status', $csv);
        $this->assertStringContainsString('26,kertek,sma_smk,pelajar_mahasiswa,7.5,3,4,normal,normal,normal', $csv);
    }

    private function submission(): Submission
    {
        $consent = ConsentVersion::query()->create([
            'version' => 'test',
            'title' => 'Persetujuan uji',
            'body' => 'Teks persetujuan lengkap tanpa placeholder.',
            'status' => ConsentStatus::ApprovedForUse,
            'is_active' => true,
        ]);

        $instrument = InstrumentVersion::query()->create([
            'code' => 'dass21',
            'version' => 'test',
            'locale' => 'id',
            'item_subscale_map' => config('dass21.item_subscale_map'),
            'severity_thresholds' => config('dass21.severity_thresholds'),
            'response_scale' => config('dass21.response_values'),
        ]);

        $submission = Submission::query()->create([
            'birth_year' => 2000,
            'age_at_submission' => 26,
            'subdistrict' => 'kertek',
            'wonosobo_resident' => true,
            'eligible' => true,
            'consent_version_id' => $consent->getKey(),
            'consent_accepted_at' => now(),
            'data_status' => DataStatus::Valid,
            'submitted_at' => now(),
        ]);

        $answers = [];

        foreach (range(1, 21) as $item) {
            $answers[DassResponse::itemColumn($item)] = 0;
        }

        $submission->dassResponse()->create($answers);

        $submission->supportingFactor()->create([
            'education_status' => 'sma_smk',
            'employment_status' => 'pelajar_mahasiswa',
            'sleep_duration_hours' => 7.5,
            'physical_activity_days' => 3,
            'social_media_hours_per_day' => 4,
            'social_support_score' => null,
        ]);

        $submission->screeningResult()->create([
            'instrument_version_id' => $instrument->getKey(),
            'depression_raw' => 0,
            'depression_final' => 0,
            'depression_category' => SeverityCategory::Normal,
            'anxiety_raw' => 0,
            'anxiety_final' => 0,
            'anxiety_category' => SeverityCategory::Normal,
            'stress_raw' => 0,
            'stress_final' => 0,
            'stress_category' => SeverityCategory::Normal,
            'computed_at' => now(),
        ]);

        return $submission;
    }
}
