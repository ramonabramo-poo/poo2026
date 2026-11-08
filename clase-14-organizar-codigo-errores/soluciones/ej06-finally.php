<?php
declare(strict_types=1);

function leerPrimeraLinea(string $ruta): string
{
    $archivo = @fopen($ruta, "r");   // la @ silencia el warning: lo tratamos nosotros
    if ($archivo === false) {
        throw new RuntimeException("No se puede abrir " . basename($ruta));
    }

    try {
        return trim((string) fgets($archivo));
    } finally {
        // Se ejecuta SIEMPRE, incluso después del return
        fclose($archivo);
        echo "(archivo cerrado) ";
    }
}

foreach (["notas.txt", "no-existe.txt"] as $ruta) {
    try {
        echo "Primera línea de $ruta: " . leerPrimeraLinea(__DIR__ . "/" . $ruta) . "<br>";
    } catch (RuntimeException $error) {
        echo "Error: " . $error->getMessage() . "<br>";
    } finally {
        echo "— fin de la prueba con $ruta<br>";
    }
}
