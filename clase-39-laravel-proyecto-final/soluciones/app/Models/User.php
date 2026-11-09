<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Rol;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    // Ejercicio 08: los valores por defecto, como en la migración. Sin esto, un usuario
    // recién creado no tiene "rol" en memoria hasta volver a leerlo de la base de datos
    // (y el modo estricto de Eloquent nos avisa con un error)
    protected $attributes = [
        'rol' => 'usuario',
    ];

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
}
