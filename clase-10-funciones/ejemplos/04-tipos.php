<?php
declare(strict_types=1);   // SIEMPRE la primera instrucción del archivo

// Le decimos a PHP qué tipo recibe cada parámetro y qué tipo devuelve
function calcularTotal(int $cantidad, float $precio): float
{
    return $cantidad * $precio;
}

// void: la función hace algo, pero no devuelve nada
function mostrarLinea(string $texto): void
{
    echo "<p>{$texto}</p>";
}

// bool: perfecta para preguntas de sí o no
function esMayorDeEdad(int $edad): bool
{
    return $edad >= 18;
}

$total = calcularTotal(3, 9.95);
mostrarLinea("Total: {$total} €");

if (esMayorDeEdad(20)) {
    mostrarLinea("Puede pasar");
}

// Quitad las // de la línea siguiente: con strict_types,
// pasar un texto donde se espera un int da un TypeError
// calcularTotal("3", 9.95);
