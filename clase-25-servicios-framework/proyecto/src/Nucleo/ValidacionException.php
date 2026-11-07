<?php
declare(strict_types=1);

namespace App\Nucleo;

use RuntimeException;

// La lanza Peticion::validar() cuando los datos no son válidos
class ValidacionException extends RuntimeException
{
    public function __construct(
        public readonly array $errores,
        public readonly array $datos,
        public readonly string $volverA,
    ) {
        parent::__construct("Los datos enviados no son válidos.");
    }
}
