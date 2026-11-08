<?php
declare(strict_types=1);

namespace App\Nucleo;

// Todo lo que devolvemos al navegador: contenido, código de estado y cabeceras
class Respuesta
{
    public function __construct(
        private string $contenido = "",
        private int $codigo = 200,
        private array $cabeceras = ["Content-Type" => "text/html; charset=utf-8"],
    ) {
    }

    public static function html(string $contenido, int $codigo = 200): Respuesta
    {
        return new Respuesta($contenido, $codigo);
    }

    public static function texto(string $contenido, int $codigo = 200): Respuesta
    {
        return new Respuesta($contenido, $codigo, ["Content-Type" => "text/plain; charset=utf-8"]);
    }

    public static function redirigir(string $destino): Respuesta
    {
        return new Respuesta("", 302, ["Location" => $destino]);
    }

    // Ejercicio 06: añadir una cabecera y devolver la misma respuesta
    public function conCabecera(string $nombre, string $valor): Respuesta
    {
        $this->cabeceras[$nombre] = $valor;
        return $this;
    }

    public function codigo(): int
    {
        return $this->codigo;
    }

    public function contenido(): string
    {
        return $this->contenido;
    }

    // El ÚNICO sitio de toda la aplicación donde se envían cabeceras y se hace echo
    public function enviar(): void
    {
        http_response_code($this->codigo);
        foreach ($this->cabeceras as $nombre => $valor) {
            header("{$nombre}: {$valor}");
        }
        echo $this->contenido;
    }
}
