<?php

namespace App\Events;

use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Ejercicio 05: el evento contrario a AlumnoMatriculado
class AlumnoDesmatriculado
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Alumno $alumno,
        public Curso $curso,
    ) {
    }
}
