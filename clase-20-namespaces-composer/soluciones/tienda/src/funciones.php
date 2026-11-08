<?php
declare(strict_types=1);

// Ejercicio 07: las funciones no se autocargan por PSR-4,
// así que este archivo va en la sección "files" de composer.json
namespace Tienda;

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}
