<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'email',
        'password',
        'nama',
        'status',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status' => 'boolean',
            'last_login' => 'datetime',
        ];
    }

    // ===== Relationships =====

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function konselor(): HasOne
    {
        return $this->hasOne(Konselor::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    // ===== Role Helpers =====

    public function isAdmin(): bool
    {
        return $this->role_id === Role::ADMIN;
    }

    public function isKonselor(): bool
    {
        return $this->role_id === Role::KONSELOR;
    }

    public function isSiswa(): bool
    {
        return $this->role_id === Role::SISWA;
    }

    public function getRoleName(): string
    {
        return $this->role?->nama ?? 'Unknown';
    }

    /**
     * Get the dashboard route based on user role.
     */
    public function dashboardRoute(): string
    {
        return match ($this->role_id) {
            Role::ADMIN => 'admin.dashboard',
            Role::KONSELOR => 'counselor.dashboard',
            Role::SISWA => 'student.dashboard',
            default => 'login',
        };
    }
}
