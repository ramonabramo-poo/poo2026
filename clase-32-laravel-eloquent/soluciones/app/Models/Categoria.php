<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable(['nombre', 'slug'])]
class Categoria extends Model
{
    use HasFactory;

    // Una categoría tiene muchos cursos
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class);
    }

    // Ejercicio 04: una relación con condiciones (los cursos publicados de la categoría)
    public function cursosPublicados(): HasMany
    {
        return $this->cursos()->where('publicado', true);
    }

    // Ejercicio 08: al guardar el nombre se genera el slug, como hicimos con el título del curso
    protected function nombre(): Attribute
    {
        return Attribute::make(
            set: fn (string $valor) => [
                'nombre' => trim($valor),
                'slug' => Str::slug($valor),
            ],
        );
    }
}
