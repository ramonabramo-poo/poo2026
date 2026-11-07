<?php
declare(strict_types=1);

namespace App\Nucleo;

// Todo lo que llega del navegador, en un solo objeto
class Peticion
{
    public function __construct(
        public readonly string $metodo,
        public readonly string $ruta,
        private array $consulta = [],      // lo que llega por la URL ($_GET)
        private array $formulario = [],    // lo que llega por POST ($_POST)
    ) {
    }

    // Construye la petición a partir de las superglobales de PHP
    public static function desdeGlobales(): Peticion
    {
        $ruta = parse_url($_SERVER["REQUEST_URI"] ?? "/", PHP_URL_PATH) ?: "/";
        $ruta = rtrim($ruta, "/") ?: "/";

        return new Peticion(strtoupper($_SERVER["REQUEST_METHOD"] ?? "GET"), $ruta, $_GET, $_POST);
    }

    public function consulta(string $clave, string $porDefecto = ""): string
    {
        return trim((string) ($this->consulta[$clave] ?? $porDefecto));
    }

    public function formulario(string $clave, string $porDefecto = ""): string
    {
        return trim((string) ($this->formulario[$clave] ?? $porDefecto));
    }

    public function todoElFormulario(): array
    {
        return $this->formulario;
    }
}
