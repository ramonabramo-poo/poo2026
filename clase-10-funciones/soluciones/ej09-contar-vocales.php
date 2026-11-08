<?php
declare(strict_types=1);

function contarVocales(string $texto): int
{
    $vocales = ["a", "e", "i", "o", "u", "á", "é", "í", "ó", "ú", "ü"];
    $cuenta = 0;

    // mb_str_split parte el texto en letras respetando las tildes
    foreach (mb_str_split(mb_strtolower($texto)) as $letra) {
        if (in_array($letra, $vocales, true)) {
            $cuenta++;
        }
    }

    return $cuenta;
}

$frase = "Programar en PHP es más fácil de lo que parece";
echo "«{$frase}» tiene " . contarVocales($frase) . " vocales";
