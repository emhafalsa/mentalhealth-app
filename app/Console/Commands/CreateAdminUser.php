<?php

namespace App\Console\Commands;

use App\Services\AdminAccountService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Membuat akun administrator penelitian secara aman';

    public function handle(AdminAccountService $adminAccounts): int
    {
        $name = text(
            label: 'Nama administrator',
            default: 'Administrator',
            required: true,
        );

        $email = text(
            label: 'Email administrator',
            required: true,
            validate: function (string $value): ?string {
                $error = Validator::make(
                    ['email' => $value],
                    ['email' => ['required', 'email', 'max:255']],
                )->errors()->first('email');

                return $error !== '' ? $error : null;
            },
        );

        $password = password(
            label: 'Password (minimal 12 karakter, huruf besar/kecil, dan angka)',
            required: true,
            validate: function (string $value): ?string {
                $error = Validator::make(
                    ['password' => $value],
                    ['password' => ['required', 'string', Password::min(12)->letters()->mixedCase()->numbers()]],
                )->errors()->first('password');

                return $error !== '' ? $error : null;
            },
        );

        $confirmation = password(
            label: 'Ulangi password',
            required: true,
        );

        if ($password !== $confirmation) {
            $this->error('Konfirmasi password tidak sama.');

            return self::FAILURE;
        }

        try {
            $admin = $adminAccounts->create($name, $email, $password);
        } catch (ValidationException $exception) {
            $this->error($exception->validator->errors()->first('email'));

            return self::FAILURE;
        }

        $this->info("Akun administrator {$admin->email} berhasil dibuat.");

        return self::SUCCESS;
    }
}
