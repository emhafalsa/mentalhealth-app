<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AdminAccountService
{
    /**
     * Akun admin dibuat di luar mass assignment agar kolom is_admin tidak
     * dapat diisi dari formulir publik.
     */
    public function create(string $name, string $email, string $password): User
    {
        $name = trim($name);
        $email = strtolower(trim($email));

        $validator = Validator::make(
            ['name' => $name, 'email' => $email, 'password' => $password],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string', Password::min(12)->letters()->mixedCase()->numbers()],
            ],
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return DB::transaction(function () use ($name, $email, $password): User {
            if (User::query()->where('email', $email)->exists()) {
                throw ValidationException::withMessages([
                    'email' => 'Email tersebut sudah terdaftar.',
                ]);
            }

            $user = new User;
            $user->forceFill([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'email_verified_at' => now(),
                'is_admin' => true,
                'is_active' => true,
            ])->save();

            return $user;
        });
    }
}
