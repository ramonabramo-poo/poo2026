<?php
declare(strict_types=1);

function registrarError(Throwable $error, string $archivo): void
{
    $linea = sprintf(
        "[%s] %s: %s (%s, línea %d)\n",
        date("Y-m-d H:i:s"),
        get_class($error),
        $error->getMessage(),
        basename($error->getFile()),
        $error->getLine()
    );
    file_put_contents($archivo, $linea, FILE_APPEND | LOCK_EX);
}

$log = __DIR__ . "/logs/errores.log";
$mensaje = "";

try {
    $config = json_decode("{esto no es json", true, flags: JSON_THROW_ON_ERROR);
} catch (JsonException $error) {
    registrarError($error, $log);
    // Al usuario, un mensaje amable; el detalle técnico, al log
    $mensaje = "Ahora mismo no podemos cargar la configuración. Inténtalo más tarde.";
}

echo $mensaje . "<br>";
echo "Última línea del log: " . htmlspecialchars((string) array_slice(file($log), -1)[0]);
