<?php

namespace App\Events;

use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Un evento: "ha pasado algo". Solo lleva los datos; no hace nada por sí mismo
class AlumnoMatriculado
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Alumno $alumno,
        public Curso $curso,
    ) {}
}
