<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Rol;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'rol' => Rol::class,
            'activo' => 'boolean',          // Ejercicio 06
            'ultimo_acceso' => 'datetime',  // Ejercicio 07
        ];
    }

    public function esAdmin(): bool
    {
        return $this->rol === Rol::Admin;
    }

    public function esEditor(): bool
    {
        return $this->rol === Rol::Editor;
    }

    // Un usuario tiene un perfil
    public function perfil(): HasOne
    {
        return $this->hasOne(Perfil::class);
    }

    // Ejercicio 04: un usuario ha creado muchos cursos
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class);
    }
}
