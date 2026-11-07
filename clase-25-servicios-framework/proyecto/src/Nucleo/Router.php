<?php
declare(strict_types=1);

namespace App\Nucleo;

class Router
{
    private array $rutas = [];
    private array $middlewareGlobal = [];   // para TODAS las rutas
    private array $middlewareDelGrupo = []; // para las rutas que se definen dentro de un grupo

    // El router recibe el contenedor: así crea los controladores y los middleware
    public function __construct(private Contenedor $contenedor)
    {
    }

    public function get(string $ruta, array|callable $accion): void
    {
        $this->anadir("GET", $ruta, $accion);
    }

    public function post(string $ruta, array|callable $accion): void
    {
        $this->anadir("POST", $ruta, $accion);
    }

    public function usar(string ...$middleware): void
    {
        array_push($this->middlewareGlobal, ...$middleware);
    }

    // Todas las rutas que se definan dentro de $definir llevarán estos middleware
    public function grupo(array $middleware, callable $definir): void
    {
        $anteriores = $this->middlewareDelGrupo;
        $this->middlewareDelGrupo = array_merge($anteriores, $middleware);
        $definir($this);
        $this->middlewareDelGrupo = $anteriores;
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

            $parametros = $this->parametros($coincidencias);
            $controlador = fn(Peticion $p) => $this->ejecutar($ruta["accion"], $p, $parametros);
            $middleware = array_merge($this->middlewareGlobal, $ruta["middleware"]);

            return $this->tuberia($middleware, $controlador)($peticion);
        }

        throw $existeConOtroMetodo
            ? new HttpException(405, "Esa dirección no admite este tipo de petición.")
            : new HttpException(404, "No encontramos esa página.");
    }

    // La TUBERÍA: cada middleware envuelve al siguiente, como las capas de una cebolla
    private function tuberia(array $middleware, callable $controlador): callable
    {
        $siguiente = $controlador;
        foreach (array_reverse($middleware) as $clase) {
            $capa = $this->contenedor->obtener($clase);
            $siguiente = fn(Peticion $p) => $capa->procesar($p, $siguiente);
        }
        return $siguiente;
    }

    private function anadir(string $metodo, string $ruta, array|callable $accion): void
    {
        $this->rutas[] = [
            "metodo" => $metodo,
            "patron" => $this->aPatron($ruta),
            "accion" => $accion,
            "middleware" => $this->middlewareDelGrupo,
        ];
    }

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
            $controlador = $this->contenedor->obtener($clase);   // ¡el contenedor le da sus dependencias!
            return $controlador->$metodo($peticion, ...$parametros);
        }
        return $accion($peticion, ...$parametros);
    }
}
