<?php
declare(strict_types=1);

// Un único sitio que recoge CUALQUIER excepción que nadie haya capturado
function manejarExcepcion(Throwable $e): void
{
    // 1. Para nosotros: todos los detalles en el registro de errores
    error_log(sprintf("[%s] %s en %s:%d", get_class($e), $e->getMessage(), $e->getFile(), $e->getLine()));

    // 2. Para el visitante: un mensaje amable, sin pistas para un atacante
    if (!headers_sent()) {
        http_response_code(500);
    }
    echo "<h1>Vaya, algo ha fallado 😕</h1>";
    echo "<p>Estamos trabajando en ello. Inténtalo de nuevo en unos minutos.</p>";
}

// Convierte los avisos (warnings) en excepciones, para que tampoco se escapen
function avisoAExcepcion(int $nivel, string $mensaje, string $archivo, int $linea): bool
{
    throw new ErrorException($mensaje, 0, $nivel, $archivo, $linea);
}

function dividir(int $a, int $b): float
{
    return $a / $b;
}

ini_set("display_errors", "0");
ini_set("log_errors", "1");
ini_set("error_log", __DIR__ . "/errores.log");
set_exception_handler("manejarExcepcion");
set_error_handler("avisoAExcepcion");

// Primero calculamos (procesamiento)...
$primera = dividir(10, 2);
$segunda = dividir(10, 0);   // DivisionByZeroError → manejarExcepcion()

// ...y solo después mostramos (salida). Si algo falla, el visitante no ve una página a medias.
echo "<p>Primera división: {$primera}</p>";
echo "<p>Segunda división: {$segunda}</p>";
