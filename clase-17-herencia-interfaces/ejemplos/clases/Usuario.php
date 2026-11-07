<?php
declare(strict_types=1);

abstract class Usuario
{
    public function __construct(
        public readonly string $nombre,
        public readonly string $email,
    ) {
    }

    abstract public function obtenerRol(): string;

    public function presentarse(): string
    {
        return "{$this->nombre} · {$this->obtenerRol()}";
    }
}
