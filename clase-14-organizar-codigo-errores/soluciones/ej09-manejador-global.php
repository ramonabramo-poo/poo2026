<?php
declare(strict_types=1);

// Como en producción: los errores no se muestran, se guardan en un archivo
ini_set("display_errors", "0");
ini_set("error_log", __DIR__ . "/logs/errores.log");

// Cualquier excepción que NADIE capture acaba aquí
set_exception_handler(function (Throwable $error): void {
    error_log(get_class($error) . ": " . $error->getMessage());
    http_response_code(500);
    echo "<h1>😵 Algo ha ido mal</h1>";
    echo "<p>Ya estamos avisados. Vuelve a intentarlo en unos minutos.</p>";
});

// Un error que nadie captura: el manejador global se encarga
throw new RuntimeException("La base de datos no responde");
