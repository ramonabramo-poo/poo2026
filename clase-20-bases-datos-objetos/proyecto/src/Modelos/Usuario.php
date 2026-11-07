<?php
declare(strict_types=1);

namespace App\Modelos;

class Usuario
{
    public function __construct(
        public readonly int $id,
        public readonly string $nombre,
        public readonly string $email,
        private string $claveHash,
    ) {
    }

    public static function desdeFila(array $fila): Usuario
    {
        return new Usuario((int) $fila["id"], $fila["nombre"], $fila["email"], $fila["clave_hash"]);
    }

    // El hash nunca sale del objeto: solo preguntamos si una clave es la buena
    public function comprobarClave(string $clave): bool
    {
        return password_verify($clave, $this->claveHash);
    }
}
