<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nombre', 'slug'])]
class Categoria extends Model
{
    use HasFactory;

    // Una categoría tiene muchos cursos
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class);
    }
}
