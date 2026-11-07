<?php
declare(strict_types=1);

namespace App\Nucleo;

class Peticion
{
    public function __construct(
        public readonly string $metodo,
        public readonly string $ruta,
        private array $consulta = [],
        private array $formulario = [],
        public readonly string $anterior = "/",    // la página desde la que venimos
    ) {
    }

    public static function desdeGlobales(): Peticion
    {
        $ruta = parse_url($_SERVER["REQUEST_URI"] ?? "/", PHP_URL_PATH) ?: "/";
        $ruta = rtrim($ruta, "/") ?: "/";
        $anterior = parse_url($_SERVER["HTTP_REFERER"] ?? "/", PHP_URL_PATH) ?: "/";

        return new Peticion(strtoupper($_SERVER["REQUEST_METHOD"] ?? "GET"), $ruta, $_GET, $_POST, $anterior);
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

    // Valida el formulario. Si algo falla, lanza ValidacionException y el framework
    // vuelve a la página anterior con los errores y lo que el usuario había escrito.
    public function validar(array $reglas): array
    {
        $validador = new Validador($this->formulario, $reglas);

        if ($validador->falla()) {
            throw new ValidacionException($validador->errores(), $this->formulario, $this->anterior);
        }
        return $validador->validados();
    }
}
