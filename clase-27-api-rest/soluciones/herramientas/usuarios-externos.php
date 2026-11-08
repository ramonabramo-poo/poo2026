<?php
declare(strict_types=1);

// Consumir una API EXTERNA con el mismo ClienteApi.
// JSONPlaceholder es una API pública y gratuita, pensada para hacer pruebas.
//   php herramientas/usuarios-externos.php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Servicios\ClienteApi;

$api = new ClienteApi("https://jsonplaceholder.typicode.com", segundosMaximos: 10);
$lineas = [];

try {
    $respuesta = $api->get("/users");
    if ($respuesta["codigo"] !== 200) {
        throw new RuntimeException("La API ha respondido con el código {$respuesta['codigo']}.");
    }
    foreach ($respuesta["datos"] as $usuario) {
        $lineas[] = sprintf("%-25s %-28s %s", $usuario["name"], $usuario["email"], $usuario["address"]["city"]);
    }
} catch (RuntimeException $e) {
    $lineas[] = "⚠️ " . $e->getMessage();
}

echo implode("\n", $lineas) . "\n";
