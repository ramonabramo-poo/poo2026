<?php
declare(strict_types=1);

use App\Controladores\CursosControlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

$router->get("/", [CursosControlador::class, "index"]);
$router->get("/cursos", [CursosControlador::class, "index"]);
$router->get("/cursos/{id:\d+}", [CursosControlador::class, "ver"]);          // solo números
$router->get("/cursos/{id:\d+}/precio", [CursosControlador::class, "precio"]);

$router->get("/hola/{nombre}", function (Peticion $peticion, string $nombre): Respuesta {
    return Respuesta::texto("¡Hola, {$nombre}! 👋");
});

// Una página de ayuda para nosotros: todas las rutas registradas
$router->get("/rutas", function (Peticion $peticion) use ($router): Respuesta {
    return Respuesta::html(vista("rutas", ["titulo" => "Rutas", "rutas" => $router->listar()]));
});
