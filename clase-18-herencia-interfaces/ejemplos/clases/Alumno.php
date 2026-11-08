<?php
declare(strict_types=1);

class Alumno extends Usuario
{
    public function __construct(string $nombre, string $email, private float $nota = 0)
    {
        parent::__construct($nombre, $email);
    }

    public function obtenerRol(): string
    {
        return $this->nota >= 5 ? "Alumno (aprobado)" : "Alumno";
    }
}
