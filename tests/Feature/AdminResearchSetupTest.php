<?php

namespace Tests\Feature;

use App\Enums\ConsentStatus;
use App\Enums\InstrumentStatus;
use App\Models\ConsentVersion;
use App\Models\InstrumentVersion;
use App\Models\ResearchSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminResearchSetupTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_persiapan_hanya_dapat_diakses_admin(): void
    {
        $this->get('/admin/setup')->assertRedirect('/login');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/setup')
            ->assertForbidden();
    }

    public function test_admin_melihat_gerbang_aktivasi_dan_form_pengaturan(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/admin/setup')
            ->assertOk()
            ->assertSee('Gerbang aktivasi penelitian')
            ->assertSee('Pengaturan penelitian')
            ->assertSee('Instrumen DASS-21 belum aktif')
            ->assertSee('Teks persetujuan belum aktif')
            ->assertSee('Persiapan penelitian');
    }

    public function test_pengaturan_penelitian_dapat_disimpan_dan_diaudit(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->put('/admin/setup/research', [
            'research_title' => 'Klasifikasi Mental Health Gen Z Wonosobo',
            'researcher_name' => 'Peneliti Uji',
            'institution' => 'Universitas Uji',
            'contact_email' => 'peneliti@example.test',
            'contact_phone' => '08123456789',
            'genz_birth_year_start' => 1997,
            'genz_birth_year_end' => 2008,
            'minimum_age' => 18,
            'region_definition' => 'Kabupaten Wonosobo',
            'study_start_date' => '2026-11-01',
            'study_end_date' => '2027-01-31',
            'age_verification_method' => 'birth_year_plus_age_confirmation',
            'access_mode' => 'participant_link',
            'ethics_confirmation_status' => 'pending',
            'ethics_reference' => 'Menunggu nomor etik',
            'retention_months' => 60,
            'deletion_procedure' => 'Data dihapus setelah masa retensi.',
        ]);

        $response->assertRedirect(route('admin.setup.index'));
        $response->assertSessionHas('status', 'Pengaturan penelitian diperbarui.');

        $settings = ResearchSetting::current();

        $this->assertSame(1997, $settings->genz_birth_year_start);
        $this->assertSame(2008, $settings->genz_birth_year_end);
        $this->assertSame('participant_link', $settings->access_mode);
        $this->assertSame($admin->getKey(), $settings->updated_by);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->getKey(),
            'action' => 'research_settings.updated',
        ]);
    }

    public function test_instrumen_terverifikasi_dapat_diaktifkan_setelah_metadata_lengkap(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post('/admin/setup/instruments', [
            'code' => 'dass21',
            'version' => 'id-2026-01',
            'locale' => 'id',
            'status' => 'verified',
            'source_reference' => 'DASS-21 Indonesian, Evelina Damanik',
            'source_url' => 'https://dass.psy.unsw.edu.au/Indonesian/Indonesian.htm',
            'source_retrieved_at' => '2026-10-21',
            'translator' => 'Evelina Damanik, M.Psi',
            'copyright_status' => 'Public domain; restricted research use',
            'verification_notes' => 'Metadata sumber dan teks butir diperiksa.',
            'instructions' => 'Instruksi DASS-21 uji.',
            'item_texts_raw' => implode("\n", array_map(
                fn (int $item): string => "Butir uji {$item}",
                range(1, 21),
            )),
        ])->assertRedirect(route('admin.setup.index'));

        $instrument = InstrumentVersion::query()->firstOrFail();

        $this->assertSame(InstrumentStatus::Verified, $instrument->status);
        $this->assertFalse($instrument->is_active);
        $this->assertNotNull($instrument->verified_at);
        $this->assertNull($instrument->effective_from);

        $this->actingAs($admin)
            ->post(route('admin.instruments.activate', $instrument))
            ->assertRedirect(route('admin.setup.index'));

        $instrument->refresh();

        $this->assertSame(InstrumentStatus::Active, $instrument->status);
        $this->assertTrue($instrument->is_active);
        $this->assertNotNull($instrument->effective_from);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->getKey(),
            'action' => 'instrument_version.activated',
        ]);
    }

    public function test_status_aktif_tidak_dapat_dipilih_lewat_form_instrumen(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from('/admin/setup/instruments/create')
            ->post('/admin/setup/instruments', [
                'code' => 'dass21',
                'version' => 'id-aktif',
                'locale' => 'id',
                'status' => 'active',
            ])
            ->assertRedirect('/admin/setup/instruments/create')
            ->assertSessionHasErrors('status');

        $this->assertSame(0, InstrumentVersion::query()->count());
    }

    public function test_consent_berplaceholder_tidak_dapat_masuk_tahap_lanjut(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/admin/setup/consents', [
                'version' => 'v1',
                'title' => 'Persetujuan',
                'body' => 'Saya [NAMA PENELITI] meminta persetujuan.',
                'status' => ConsentStatus::ApprovedForUse->value,
            ])
            ->assertSessionHasErrors('body');

        $this->assertSame(0, ConsentVersion::query()->count());
    }

    public function test_consent_disetujui_dapat_diaktifkan_dan_menonaktifkan_versi_lain(): void
    {
        $admin = User::factory()->admin()->create();

        $oldConsent = ConsentVersion::query()->create([
            'version' => 'v0',
            'title' => 'Persetujuan lama',
            'body' => 'Teks persetujuan lama tanpa placeholder.',
            'status' => ConsentStatus::ApprovedForUse,
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->post('/admin/setup/consents', [
                'version' => 'v1',
                'title' => 'Persetujuan baru',
                'body' => 'Teks persetujuan baru tanpa placeholder.',
                'status' => ConsentStatus::ApprovedForUse->value,
            ])
            ->assertRedirect(route('admin.setup.index'));

        $consent = ConsentVersion::query()->where('version', 'v1')->firstOrFail();

        $this->assertSame(ConsentStatus::ApprovedForUse, $consent->status);
        $this->assertNotNull($consent->verified_at);
        $this->assertFalse($consent->is_active);

        $this->actingAs($admin)
            ->post(route('admin.consents.activate', $consent))
            ->assertRedirect(route('admin.setup.index'));

        $this->assertSame(ConsentStatus::ApprovedForUse, $consent->fresh()->status);
        $this->assertTrue($consent->fresh()->is_active);
        $this->assertSame(ConsentStatus::ApprovedForUse, $oldConsent->fresh()->status);
        $this->assertFalse($oldConsent->fresh()->is_active);
    }

    public function test_consent_siap_ditinjau_belum_dapat_diaktifkan(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/admin/setup/consents', [
                'version' => 'v1',
                'title' => 'Persetujuan baru',
                'body' => 'Teks persetujuan baru tanpa placeholder.',
                'status' => ConsentStatus::ReadyForReview->value,
            ])
            ->assertRedirect(route('admin.setup.index'));

        $consent = ConsentVersion::query()->where('version', 'v1')->firstOrFail();

        $this->assertSame(ConsentStatus::ReadyForReview, $consent->status);
        $this->assertNull($consent->verified_at);

        $this->actingAs($admin)
            ->post(route('admin.consents.activate', $consent))
            ->assertRedirect(route('admin.setup.index'))
            ->assertSessionHasErrors('consent');

        $this->assertFalse($consent->fresh()->is_active);
    }

    public function test_instrumen_aktif_tidak_dapat_diedit(): void
    {
        $admin = User::factory()->admin()->create();
        $instrument = InstrumentVersion::query()->create([
            'code' => 'dass21',
            'version' => 'aktif',
            'locale' => 'id',
            'status' => InstrumentStatus::Active,
            'item_subscale_map' => config('dass21.item_subscale_map'),
            'severity_thresholds' => config('dass21.severity_thresholds'),
            'response_scale' => config('dass21.response_values'),
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.instruments.edit', $instrument))
            ->assertRedirect(route('admin.setup.index'))
            ->assertSessionHasErrors('instrument');
    }
}
