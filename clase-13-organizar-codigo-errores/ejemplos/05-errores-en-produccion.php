<?php
declare(strict_types=1);

// En una web PUBLICADA los errores NO se muestran al visitante
// (darían pistas a un atacante): se guardan en un archivo de registro.
ini_set("display_errors", "0");
ini_set("log_errors", "1");
ini_set("error_log", __DIR__ . "/errores.log");

// También podemos escribir nosotros en el registro
error_log("Alguien ha visitado la página de pruebas");

try {
    $resultado = intdiv(10, 0);
} catch (DivisionByZeroError $e) {
    error_log("Error en el cálculo: " . $e->getMessage());
    echo "Lo sentimos, ha ocurrido un problema. Inténtalo más tarde.";
}

// Abrid el archivo errores.log de esta carpeta para ver lo que se ha guardado
