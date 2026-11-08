<?php
declare(strict_types=1);

namespace App\Nucleo;

// Router de las soluciones: admite {id:\d+} (restricciones) y sabe listar sus rutas
class Router
{
    private array $rutas = [];

    public function get(string $ruta, array|callable $accion): void
    {
        $this->anadir("GET", $ruta, $accion);
    }

    public function post(string $ruta, array|callable $accion): void
    {
        $this->anadir("POST", $ruta, $accion);
    }

    // Para la página /rutas: método, dirección y quién la atiende
    public function listar(): array
    {
        return array_map(fn(array $ruta) => [
            "metodo" => $ruta["metodo"],
            "ruta" => $ruta["original"],
            "accion" => is_array($ruta["accion"]) ? implode("::", $ruta["accion"]) : "función anónima",
        ], $this->rutas);
    }

    public function despachar(Peticion $peticion): Respuesta
    {
        $existeConOtroMetodo = false;

        foreach ($this->rutas as $ruta) {
            if (preg_match($ruta["patron"], $peticion->ruta, $coincidencias) !== 1) {
                continue;
            }
            if ($ruta["metodo"] !== $peticion->metodo) {
                $existeConOtroMetodo = true;
                continue;
            }
            return $this->ejecutar($ruta["accion"], $peticion, $this->parametros($coincidencias));
        }

        if ($existeConOtroMetodo) {
            throw new HttpException(405, "Esa dirección no admite este tipo de petición.");
        }
        throw new HttpException(404, "No encontramos esa página.");
    }

    private function anadir(string $metodo, string $ruta, array|callable $accion): void
    {
        $this->rutas[] = [
            "metodo" => $metodo,
            "original" => $ruta,
            "patron" => $this->aPatron($ruta),
            "accion" => $accion,
        ];
    }

    // "/cursos/{id:\d+}" → "#^/cursos/(?P<id>\d+)$#"   y   "/hola/{nombre}" → "(?P<nombre>[^/]+)"
    private function aPatron(string $ruta): string
    {
        $patron = preg_replace_callback(
            "#\{(\w+)(?::([^}]+))?\}#",
            fn(array $m) => "(?P<{$m[1]}>" . ($m[2] ?? "[^/]+") . ")",
            $ruta
        );
        return "#^" . $patron . "$#";
    }

    private function parametros(array $coincidencias): array
    {
        $parametros = [];
        foreach ($coincidencias as $nombre => $valor) {
            if (is_string($nombre)) {
                $parametros[$nombre] = ctype_digit($valor) ? (int) $valor : $valor;
            }
        }
        return $parametros;
    }

    private function ejecutar(array|callable $accion, Peticion $peticion, array $parametros): Respuesta
    {
        if (is_array($accion)) {
            [$clase, $metodo] = $accion;
            return (new $clase())->$metodo($peticion, ...$parametros);
        }
        return $accion($peticion, ...$parametros);
    }
}
