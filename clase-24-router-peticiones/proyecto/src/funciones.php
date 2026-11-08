<?php
declare(strict_types=1);

function e(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

// Genera el HTML de una vista dentro del layout común y lo DEVUELVE como texto.
// $datos se convierte en variables: ["cursos" => ...] pasa a ser $cursos dentro de la vista.
function vista(string $nombre, array $datos = []): string
{
    extract($datos);

    ob_start();                                          // empezamos a "grabar" la salida
    require __DIR__ . "/../vistas/{$nombre}.php";
    $contenido = ob_get_clean();                         // y la guardamos en $contenido

    ob_start();
    require __DIR__ . "/../vistas/layout.php";           // el layout imprime $contenido
    return ob_get_clean();
}
