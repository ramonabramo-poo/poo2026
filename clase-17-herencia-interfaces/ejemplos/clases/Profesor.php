<?php
declare(strict_types=1);

class Profesor extends Usuario
{
    public function __construct(string $nombre, string $email, public readonly string $especialidad)
    {
        parent::__construct($nombre, $email);
    }

    public function obtenerRol(): string
    {
        return "Docente de {$this->especialidad}";
    }
}
