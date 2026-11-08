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

    // Ejercicio 05
    public function esPost(): bool
    {
        return $this->metodo === "POST";
    }

    // Ejercicio 05: un número de la URL, nunca menor que el mínimo
    public function consultaEntero(string $clave, int $porDefecto = 0, int $minimo = PHP_INT_MIN): int
    {
        $valor = $this->consulta[$clave] ?? null;
        $numero = is_numeric($valor) ? (int) $valor : $porDefecto;
        return max($minimo, $numero);
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
