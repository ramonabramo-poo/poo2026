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

    public static function json(mixed $datos, int $codigo = 200, array $cabeceras = []): Respuesta
    {
        $json = json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        return new Respuesta($json, $codigo, ["Content-Type" => "application/json; charset=utf-8"] + $cabeceras);
    }

    // 204 No Content: todo ha ido bien y no hay nada que devolver (por ejemplo, tras borrar)
    public static function vacia(): Respuesta
    {
        return new Respuesta("", 204, []);
    }

    public static function redirigir(string $destino): Respuesta
    {
        return new Respuesta("", 302, ["Location" => $destino]);
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
