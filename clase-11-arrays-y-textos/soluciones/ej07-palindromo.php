<?php
declare(strict_types=1);

function limpiar(string $texto): string
{
    $texto = mb_strtolower($texto);
    $texto = str_replace(["á", "é", "í", "ó", "ú", "ü"], ["a", "e", "i", "o", "u", "u"], $texto);
    // Fuera espacios y signos de puntuación
    return str_replace([" ", ",", ".", "¡", "!", "¿", "?"], "", $texto);
}

function esPalindromo(string $texto): bool
{
    $limpio = limpiar($texto);
    $alReves = implode("", array_reverse(mb_str_split($limpio)));

    return $limpio === $alReves;
}

$frases = ["Dábale arroz a la zorra el abad", "Anita lava la tina", "Hola, mundo"];

foreach ($frases as $frase) {
    echo "«{$frase}»: " . (esPalindromo($frase) ? "es un palíndromo" : "no lo es") . "<br>";
}
