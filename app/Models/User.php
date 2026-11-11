<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'activo',
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
            'activo' => 'boolean',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'rol_usuario', 'id_usuario', 'id_rol')
            ->withTimestamps();
    }

    public function tieneRol(string $nombre): bool
    {
        return $this->roles()->where('nombre', $nombre)->exists();
    }

    public function esAdministrador(): bool
    {
        return $this->tieneRol('Administrador');
    }
}
