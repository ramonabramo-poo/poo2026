<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

// Las columnas que se pueden rellenar de golpe con create() o update()
#[Fillable([
    'categoria_id', 'titulo', 'descripcion', 'imagen', 'horas',
    'precio', 'plazas', 'fecha_inicio', 'publicado',
])]
class Curso extends Model
{
    use HasFactory;
    use SoftDeletes;

    const IVA = 0.21;

    // Cómo convertir cada columna al leerla de la base de datos
    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'fecha_inicio' => 'date',
            'publicado' => 'boolean',
        ];
    }

    // RELACIONES

    // Un curso pertenece a una categoría
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    // Un curso tiene muchos alumnos, a través de la tabla alumno_curso
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(Alumno::class)
            ->withPivot('nota')
            ->withTimestamps();
    }

    // SCOPES: trozos de consulta con nombre

    #[Scope]
    protected function publicados(Builder $consulta): void
    {
        $consulta->where('publicado', true);
    }

    #[Scope]
    protected function buscar(Builder $consulta, string $texto): void
    {
        $consulta->where('titulo', 'like', "%{$texto}%");
    }

    // ACCESSORS Y MUTATORS

    // Un atributo calculado: $curso->precio_con_iva
    protected function precioConIva(): Attribute
    {
        return Attribute::make(
            get: fn () => round($this->precio * (1 + self::IVA), 2),
        );
    }

    // Al guardar el título, se genera también el slug
    protected function titulo(): Attribute
    {
        return Attribute::make(
            set: fn (string $valor) => [
                'titulo' => trim($valor),
                'slug' => Str::slug($valor),
            ],
        );
    }
}
