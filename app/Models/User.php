<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Kolom is_admin sengaja tidak dimasukkan ke Fillable agar tidak bisa
     * diubah lewat mass assignment dari formulir publik.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    public function modelExperiments(): HasMany
    {
        return $this->hasMany(ModelExperiment::class, 'created_by');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}
