<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\Models\Contracts\HasName;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function canAccessPanel(Panel $panel): bool
{
    return $this->role_id === 2;
}
public function getFilamentName(): string
{
    $name = trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));

    return $name !== '' ? $name : ($this->email ?? 'User');
}
}
