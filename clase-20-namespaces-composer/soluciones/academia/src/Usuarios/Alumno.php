<?php
declare(strict_types=1);

namespace App\Usuarios;

use DateTimeImmutable;

// Usuario está en el MISMO namespace: no hace falta ningún use para él
class Alumno extends Usuario
{
    public function __construct(
        string $nombre,
        string $email,
        private float $nota = 0,
        public readonly ?DateTimeImmutable $fechaAlta = null,
    ) {
        parent::__construct($nombre, $email);
    }

    public function obtenerRol(): string
    {
        return $this->nota >= 5 ? "Alumno (aprobado)" : "Alumno";
    }
}
