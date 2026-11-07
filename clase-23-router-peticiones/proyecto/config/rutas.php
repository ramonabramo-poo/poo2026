<?php
declare(strict_types=1);

// TODAS las rutas de la web, de un vistazo.
// Cada ruta: método + dirección + quién la atiende [Controlador::class, "metodo"]

use App\Controladores\CursosControlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

$router->get("/", [CursosControlador::class, "index"]);
$router->get("/cursos", [CursosControlador::class, "index"]);
$router->get("/cursos/{id}", [CursosControlador::class, "ver"]);

// Una ruta también puede atenderla una función anónima
$router->get("/hola/{nombre}", function (Peticion $peticion, string $nombre): Respuesta {
    return Respuesta::texto("¡Hola, {$nombre}! 👋");
});
