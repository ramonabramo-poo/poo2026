<?php
declare(strict_types=1);

use App\Controladores\AuthControlador;
use App\Controladores\CursosControlador;
use App\Middleware\Autenticado;
use App\Middleware\VerificarCsrf;
use App\Nucleo\Respuesta;
use App\Nucleo\Router;

// Middleware para TODAS las rutas
$router->usar(VerificarCsrf::class);

$router->get("/", fn() => Respuesta::redirigir("/cursos"));

// Rutas públicas
$router->get("/cursos", [CursosControlador::class, "index"]);
$router->get("/cursos/{id:\d+}", [CursosControlador::class, "ver"]);

$router->get("/login", [AuthControlador::class, "formulario"]);
$router->post("/login", [AuthControlador::class, "entrar"]);
$router->post("/logout", [AuthControlador::class, "salir"]);

// Rutas que exigen haber iniciado sesión
$router->grupo([Autenticado::class], function (Router $router): void {
    $router->get("/cursos/crear", [CursosControlador::class, "crear"]);
    $router->post("/cursos", [CursosControlador::class, "guardar"]);
    $router->get("/cursos/{id:\d+}/editar", [CursosControlador::class, "editar"]);
    $router->post("/cursos/{id:\d+}", [CursosControlador::class, "actualizar"]);
    $router->post("/cursos/{id:\d+}/borrar", [CursosControlador::class, "borrar"]);
});
