<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    // Laravel pluralizaría "Profesor" como "profesors": le decimos el nombre de verdad
    protected $table = 'profesores';
}
