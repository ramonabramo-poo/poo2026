<?php
declare(strict_types=1);

use App\Controladores\AuthControlador;
use App\Controladores\CursosControlador;
use App\Controladores\PerfilControlador;
use App\Controladores\PresupuestoControlador;
use App\Controladores\RegistroControlador;
use App\Middleware\Autenticado;
use App\Middleware\CabecerasSeguridad;
use App\Middleware\LimiteIntentos;
use App\Middleware\ModoMantenimiento;
use App\Middleware\RegistroPeticiones;
use App\Middleware\SoloInvitados;
use App\Middleware\VerificarCsrf;
use App\Nucleo\Respuesta;
use App\Nucleo\Router;

// Primero el registro (para que mida TODO) y después el CSRF
$router->usar(RegistroPeticiones::class, CabecerasSeguridad::class, ModoMantenimiento::class, VerificarCsrf::class);   // ejercicios 05 y 06

$router->get("/", fn() => Respuesta::redirigir("/cursos"));
$router->get("/cursos", [CursosControlador::class, "index"]);
$router->get("/cursos/{id:\d+}", [CursosControlador::class, "ver"]);
$router->get("/cursos/{id:\d+}/presupuesto", [PresupuestoControlador::class, "calcular"]);   // ejercicio 07
$router->post("/logout", [AuthControlador::class, "salir"]);

// Solo para quien NO ha iniciado sesión
$router->grupo([SoloInvitados::class], function (Router $router): void {
    $router->get("/login", [AuthControlador::class, "formulario"]);
    $router->grupo([LimiteIntentos::class], function (Router $router): void {   // ejercicio 10
        $router->post("/login", [AuthControlador::class, "entrar"]);
    });
    $router->get("/registro", [RegistroControlador::class, "formulario"]);
    $router->post("/registro", [RegistroControlador::class, "guardar"]);
});

// Solo para quien SÍ ha iniciado sesión
$router->grupo([Autenticado::class], function (Router $router): void {
    $router->get("/perfil", [PerfilControlador::class, "ver"]);   // ejercicio 08
    $router->get("/cursos/crear", [CursosControlador::class, "crear"]);
    $router->post("/cursos", [CursosControlador::class, "guardar"]);
    $router->get("/cursos/{id:\d+}/editar", [CursosControlador::class, "editar"]);
    $router->post("/cursos/{id:\d+}", [CursosControlador::class, "actualizar"]);
    $router->post("/cursos/{id:\d+}/borrar", [CursosControlador::class, "borrar"]);
});
