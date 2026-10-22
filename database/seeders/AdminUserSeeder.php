<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\AdminAccountService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(AdminAccountService $adminAccounts): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');
        $name = env('ADMIN_NAME') ?: 'Administrator';

        if (blank($email) || blank($password)) {
            $this->command?->warn(
                'ADMIN_EMAIL dan ADMIN_PASSWORD kosong. Gunakan "php artisan admin:create" untuk membuat akun admin.'
            );

            return;
        }

        $email = Str::lower(trim((string) $email));

        if (User::query()->where('email', $email)->exists()) {
            $this->command?->warn("Akun admin {$email} sudah ada; password tidak diubah.");

            return;
        }

        $adminAccounts->create($name, $email, (string) $password);

        $this->command?->info("Akun admin {$email} berhasil dibuat.");
    }
}
