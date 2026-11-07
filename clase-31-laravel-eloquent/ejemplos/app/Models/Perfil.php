<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Sin #[Table], Laravel buscaría la tabla "perfils"
#[Table('perfiles')]
#[Fillable(['ciudad', 'biografia'])]
class Perfil extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
