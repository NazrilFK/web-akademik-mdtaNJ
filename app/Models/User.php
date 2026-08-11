<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Mass Assignment
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'no_hp',
        'last_login',
        'role',
        'nama_kelas',
    ];

    /**
     * Hidden Attribute
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting Attribute
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
            'last_login' => 'datetime',
        ];
    }

    /**
     * Hak akses ke Panel Filament
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, [
            'admin',
            'guru',
            'kepala_madrasah',
        ]) && $this->status;
    }

    /**
     * Relasi Jadwal Mengajar
     */
    public function jadwalMengajar()
    {
        return $this->hasMany(
            \App\Models\JadwalPelajaran::class,
            'guru_id'
        );
    }
}