<?php
declare(strict_types=1);

namespace App\Nucleo;

use RuntimeException;

// Una excepción que ya sabe con qué código HTTP responder: 403, 404…
class HttpException extends RuntimeException
{
    public function __construct(public readonly int $codigo, string $mensaje = "")
    {
        parent::__construct($mensaje);
    }
}
