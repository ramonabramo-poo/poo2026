<?php
declare(strict_types=1);

use App\Controladores\Api\CursosApiControlador;
use App\Controladores\AuthControlador;
use App\Controladores\CursosControlador;
use App\Middleware\Autenticado;
use App\Middleware\TokenApi;
use App\Middleware\VerificarCsrf;
use App\Nucleo\Respuesta;
use App\Nucleo\Router;

// Middleware para TODAS las rutas (en la API no actúa: allí se usa el token)
$router->usar(VerificarCsrf::class);

// ---------- Web ----------
$router->get("/", fn() => Respuesta::redirigir("/cursos"));
$router->get("/cursos", [CursosControlador::class, "index"]);
$router->get("/cursos/{id:\d+}", [CursosControlador::class, "ver"]);

$router->get("/login", [AuthControlador::class, "formulario"]);
$router->post("/login", [AuthControlador::class, "entrar"]);
$router->post("/logout", [AuthControlador::class, "salir"]);

$router->grupo([Autenticado::class], function (Router $router): void {
    $router->get("/cursos/crear", [CursosControlador::class, "crear"]);
    $router->post("/cursos", [CursosControlador::class, "guardar"]);
    $router->get("/cursos/{id:\d+}/editar", [CursosControlador::class, "editar"]);
    $router->post("/cursos/{id:\d+}", [CursosControlador::class, "actualizar"]);
    $router->post("/cursos/{id:\d+}/borrar", [CursosControlador::class, "borrar"]);
});

// ---------- API REST ----------
// Leer es público
$router->get("/api/cursos", [CursosApiControlador::class, "index"]);
$router->get("/api/cursos/{id:\d+}", [CursosApiControlador::class, "ver"]);

// Escribir exige el token
$router->grupo([TokenApi::class], function (Router $router): void {
    $router->post("/api/cursos", [CursosApiControlador::class, "guardar"]);
    $router->put("/api/cursos/{id:\d+}", [CursosApiControlador::class, "actualizar"]);
    $router->delete("/api/cursos/{id:\d+}", [CursosApiControlador::class, "borrar"]);
});
