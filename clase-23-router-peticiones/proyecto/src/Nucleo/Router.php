<?php
declare(strict_types=1);

namespace App\Nucleo;

// El ENRUTADOR: una lista de rutas y, para cada una, quién la atiende
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

    // Busca la ruta que coincide con la petición y ejecuta su acción
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
            return Respuesta::html(vista("errores/405", ["titulo" => "Método no permitido"]), 405);
        }
        return Respuesta::html(vista("errores/404", ["titulo" => "Página no encontrada"]), 404);
    }

    private function anadir(string $metodo, string $ruta, array|callable $accion): void
    {
        $this->rutas[] = [
            "metodo" => $metodo,
            "patron" => $this->aPatron($ruta),
            "accion" => $accion,
        ];
    }

    // "/cursos/{id}"  →  "#^/cursos/(?P<id>[^/]+)$#"
    private function aPatron(string $ruta): string
    {
        $patron = preg_replace("#\{(\w+)\}#", "(?P<$1>[^/]+)", $ruta);
        return "#^" . $patron . "$#";
    }

    // Nos quedamos solo con los parámetros con nombre; los números, como int
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
        // [CursosControlador::class, "ver"] → new CursosControlador() y llamamos a ver()
        if (is_array($accion)) {
            [$clase, $metodo] = $accion;
            $controlador = new $clase();
            return $controlador->$metodo($peticion, ...$parametros);
        }
        return $accion($peticion, ...$parametros);
    }
}
