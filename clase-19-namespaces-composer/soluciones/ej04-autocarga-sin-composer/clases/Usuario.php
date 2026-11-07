<?php
declare(strict_types=1);

abstract class Usuario
{
    public function __construct(public readonly string $nombre)
    {
    }

    abstract public function obtenerRol(): string;
}
