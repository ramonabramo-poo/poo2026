<?php
declare(strict_types=1);

const MODO_DESARROLLO = false;   // en un servidor de verdad: false

// Los avisos (warnings) también se convierten en excepciones: nada se escapa
set_error_handler(function (int $nivel, string $mensaje, string $archivo, int $linea): bool {
    throw new ErrorException($mensaje, 0, $nivel, $archivo, $linea);
});

set_exception_handler(function (Throwable $error): void {
    error_log(get_class($error) . ": " . $error->getMessage() . " en " . $error->getFile() . ":" . $error->getLine());
    http_response_code(500);
    if (MODO_DESARROLLO) {
        echo "<pre>" . htmlspecialchars((string) $error) . "</pre>";
    } else {
        echo "<h1>Algo ha ido mal</h1><p>Lo estamos arreglando. Inténtalo en unos minutos.</p>";
    }
});

$precios = ["teclado" => 49.90];
// Leer una clave que no existe es un warning… que ahora se convierte en excepción
echo $precios["monitor"];
