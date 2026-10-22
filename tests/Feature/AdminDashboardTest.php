<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_menampilkan_kesiapan_penelitian_tanpa_data_palsu(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Instrumen penelitian')
            ->assertSee('Belum lengkap')
            ->assertSee('Belum ada eksperimen')
            ->assertSee('Batas penggunaan hasil')
            ->assertDontSee('Test User');
    }
}
