<?php
declare(strict_types=1);

class Profesor extends Usuario
{
    public function obtenerRol(): string
    {
        return "Profesor";
    }
}
