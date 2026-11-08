<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nombre', 'apellidos', 'email', 'telefono', 'fecha_nacimiento'])]
class Alumno extends Model
{
    use HasFactory;
    // Para poder enviarle notificaciones: usa la columna email
    use Notifiable;

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
        ];
    }

    // Un alumno está matriculado en muchos cursos
    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class)
            ->withPivot('nota')
            ->withTimestamps();
    }

    // $alumno->nombre_completo
    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->nombre} {$this->apellidos}",
        );
    }

    // El correo siempre se guarda en minúsculas
    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn (string $valor) => mb_strtolower(trim($valor)),
        );
    }
}
