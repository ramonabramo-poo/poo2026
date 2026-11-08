<?php
declare(strict_types=1);

function saludo(string $nombre, string $idioma = "es", bool $formal = false): string
{
    $palabra = match ($idioma) {
        "en" => "Hello",
        "fr" => "Bonjour",
        "it" => "Ciao",
        default => "Hola",
    };

    $trato = $formal && $idioma === "es" ? "señor/a " : "";

    return "$palabra, $trato$nombre";
}

echo saludo("Lucía") . "<br>";
echo saludo("Lucía", "fr") . "<br>";
// Argumentos con nombre: nos saltamos $idioma
echo saludo("Martínez", formal: true);
