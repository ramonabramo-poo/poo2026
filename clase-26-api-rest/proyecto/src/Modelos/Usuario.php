<?php
declare(strict_types=1);

namespace App\Modelos;

use App\Nucleo\Modelo;

class Usuario extends Modelo
{
    protected static string $tabla = "usuarios";
    protected static array $columnas = [
        "nombre" => "string",
        "email" => "string",
        "clave_hash" => "string",
    ];

    public string $nombre = "";
    public string $email = "";
    public string $clave_hash = "";

    public function comprobarClave(string $clave): bool
    {
        return password_verify($clave, $this->clave_hash);
    }
}
