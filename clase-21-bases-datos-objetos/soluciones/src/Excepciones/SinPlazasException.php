<?php
declare(strict_types=1);

namespace App\Excepciones;

use RuntimeException;

// Ejercicio 07
class SinPlazasException extends RuntimeException
{
    public function __construct(string $tituloCurso)
    {
        parent::__construct("No quedan plazas en «{$tituloCurso}».");
    }
}
