<?php
declare(strict_types=1);

// Cliente de consola para probar la API. Desde la carpeta del proyecto:
//   php herramientas/cliente-api.php
//   php herramientas/cliente-api.php http://localhost:8000     (otra dirección)

require_once __DIR__ . "/../vendor/autoload.php";

use App\Nucleo\Entorno;
use App\Servicios\ClienteApi;

function mostrar(string $titulo, array $respuesta): void
{
    echo "\n=== {$titulo} → {$respuesta['codigo']}\n";
    echo json_encode($respuesta["datos"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
}

Entorno::cargar(__DIR__ . "/../.env");
$urlBase = $argv[1] ?? Entorno::obtener("API_URL", "http://academia-mvc.test");
$api = new ClienteApi($urlBase, Entorno::obtener("API_TOKEN"));

$lista = $api->get("/api/cursos?q=php");
$creado = $api->post("/api/cursos", ["titulo" => "Curso de prueba", "horas" => 10, "precio" => 50, "plazas" => 5]);
$id = $creado["datos"]["datos"]["id"] ?? 0;
$actualizado = $api->put("/api/cursos/{$id}", ["titulo" => "Curso de prueba (editado)", "horas" => 12, "precio" => 55, "plazas" => 5]);
$borrado = $api->delete("/api/cursos/{$id}");
$sinToken = (new ClienteApi($urlBase))->delete("/api/cursos/{$id}");

mostrar("GET /api/cursos?q=php", $lista);
mostrar("POST /api/cursos", $creado);
mostrar("PUT /api/cursos/{$id}", $actualizado);
mostrar("DELETE /api/cursos/{$id}", $borrado);
mostrar("DELETE sin token", $sinToken);
