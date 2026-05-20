<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected $appends = [
        'level',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getLevelAttribute(): int
    {
        $roleName = $this->role?->name ?? ($this->role_id ? Role::find($this->role_id)?->name : null);
        return match ($roleName) {
            'super_admin' => 4,
            'manager' => 3,
            'finance', 'support', 'moderator' => 2,
            default => 1,
        };
    }
}
