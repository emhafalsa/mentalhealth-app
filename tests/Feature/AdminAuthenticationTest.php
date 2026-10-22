<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_diarahkan_ke_halaman_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_halaman_login_dapat_dibuka_tanpa_registrasi_publik(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Masuk sebagai admin')
            ->assertDontSee('Daftar akun');
    }

    public function test_admin_aktif_dapat_masuk_dan_melihat_dashboard(): void
    {
        $admin = User::factory()->admin()->create([
            'password' => 'RahasiaAman123',
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'RahasiaAman123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($admin);
        $this->assertNotNull($admin->fresh()->last_login_at);

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee($admin->name)
            ->assertSee('Ringkasan data responden');
    }

    public function test_pengguna_biasa_tidak_dapat_masuk(): void
    {
        $user = User::factory()->create([
            'password' => 'RahasiaAman123',
        ]);

        $this->from('/login')
            ->post('/login', [
                'email' => $user->email,
                'password' => 'RahasiaAman123',
            ])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_nonaktif_tidak_dapat_masuk(): void
    {
        $admin = User::factory()->admin()->inactive()->create([
            'password' => 'RahasiaAman123',
        ]);

        $this->from('/login')
            ->post('/login', [
                'email' => $admin->email,
                'password' => 'RahasiaAman123',
            ])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_pengguna_biasa_tidak_dapat_membuka_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertForbidden();
    }

    public function test_admin_dapat_keluar(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/logout')
            ->assertRedirect('/login');

        $this->assertGuest();
    }
}
