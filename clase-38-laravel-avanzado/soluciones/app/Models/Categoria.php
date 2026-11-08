<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

#[Fillable(['nombre', 'slug'])]
class Categoria extends Model
{
    use HasFactory;

    // Ejercicio 03: si cambia una categoría, el menú guardado en la caché ya no vale
    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('categorias-menu'));
        static::deleted(fn () => Cache::forget('categorias-menu'));
    }

    // Una categoría tiene muchos cursos
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class);
    }
}
