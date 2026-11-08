<?php
declare(strict_types=1);

class Alumno extends Usuario
{
    public function obtenerRol(): string
    {
        return "Alumno";
    }
}
