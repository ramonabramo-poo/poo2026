<?php
declare(strict_types=1);

namespace App\Excepciones;

use RuntimeException;

class CursoConAlumnosException extends RuntimeException
{
    public function __construct(int $cursoId)
    {
        parent::__construct("No se puede borrar el curso {$cursoId}: tiene alumnos matriculados.");
    }
}
