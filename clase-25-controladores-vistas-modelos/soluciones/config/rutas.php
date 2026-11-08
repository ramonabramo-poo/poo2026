<?php
declare(strict_types=1);

use App\Controladores\CursosControlador;
use App\Nucleo\Respuesta;

$router->get("/", fn() => Respuesta::redirigir("/cursos"));

// Las siete rutas de un recurso, en el mismo orden que usa Laravel
$router->get("/cursos", [CursosControlador::class, "index"]);
$router->get("/cursos/crear", [CursosControlador::class, "crear"]);
$router->post("/cursos", [CursosControlador::class, "guardar"]);
$router->get("/cursos/{id:\d+}", [CursosControlador::class, "ver"]);
$router->get("/cursos/{id:\d+}/editar", [CursosControlador::class, "editar"]);
$router->post("/cursos/{id:\d+}", [CursosControlador::class, "actualizar"]);
$router->post("/cursos/{id:\d+}/borrar", [CursosControlador::class, "borrar"]);

$router->get("/alumnos", [App\Controladores\AlumnosControlador::class, "index"]);
$router->get("/alumnos/crear", [App\Controladores\AlumnosControlador::class, "crear"]);     // ejercicio 09
$router->post("/alumnos", [App\Controladores\AlumnosControlador::class, "guardar"]);        // ejercicio 09
$router->get("/catalogo", [App\Controladores\CatalogoControlador::class, "tarjetas"]);      // ejercicio 05
$router->get("/admin", [App\Controladores\AdminControlador::class, "index"]);              // ejercicio 07
