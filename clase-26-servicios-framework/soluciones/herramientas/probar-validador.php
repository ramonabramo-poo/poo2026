<?php
declare(strict_types=1);

// Ejercicio 04: php herramientas/probar-validador.php
require __DIR__ . "/../vendor/autoload.php";

use App\Nucleo\Validador;

$datos = ["nivel" => "experto", "web" => "no es una web", "edad" => "17"];
$reglas = ["nivel" => "obligatorio|en:basico,medio,avanzado", "web" => "url", "edad" => "entero|min:18"];

$validador = new Validador($datos, $reglas);
foreach ($validador->errores() as $campo => $error) {
    echo "$campo: $error" . PHP_EOL;
}

$bueno = new Validador(["nivel" => "medio", "web" => "https://academia.test", "edad" => "30"], $reglas);
echo $bueno->falla() ? "❌ Algo falla" : "✅ Datos correctos", PHP_EOL;
