<?php
declare(strict_types=1);

namespace App\Excepciones;

use RuntimeException;

// Ejercicio 08
class EmailDuplicadoException extends RuntimeException
{
    public function __construct(string $email)
    {
        parent::__construct("Ya hay un alumno con el email {$email}.");
    }
}
