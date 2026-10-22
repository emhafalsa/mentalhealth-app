<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AdminAccountService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AdminAccountServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_membuat_admin_dengan_email_normal_dan_password_hash(): void
    {
        $admin = app(AdminAccountService::class)->create(
            'Admin Penelitian',
            '  ADMIN@Example.COM ',
            'RahasiaAman123',
        );

        $this->assertSame('admin@example.com', $admin->email);
        $this->assertTrue($admin->is_admin);
        $this->assertTrue($admin->is_active);
        $this->assertNotNull($admin->email_verified_at);
        $this->assertTrue(Hash::check('RahasiaAman123', $admin->password));
        $this->assertTrue($admin->isAdmin());
    }

    public function test_password_lemah_ditolak(): void
    {
        $this->expectException(ValidationException::class);

        app(AdminAccountService::class)->create(
            'Admin Penelitian',
            'admin@example.com',
            'password',
        );
    }

    public function test_email_duplikat_ditolak(): void
    {
        User::factory()->admin()->create(['email' => 'admin@example.com']);

        $this->expectException(ValidationException::class);

        app(AdminAccountService::class)->create(
            'Admin Kedua',
            'admin@example.com',
            'RahasiaAman123',
        );
    }
}
