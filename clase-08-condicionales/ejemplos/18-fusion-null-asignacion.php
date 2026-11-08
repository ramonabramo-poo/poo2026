<?php
// ??= : asigna SOLO si la variable no existe o es null
$config = [
    "tema" => "oscuro",
];

$config["tema"] ??= "claro";      // ya tenía valor: no cambia
$config["idioma"] ??= "es";       // no existía: lo crea

$contador = null;
$contador ??= 0;                  // era null: ahora vale 0

echo "Tema: {$config["tema"]}<br>";
echo "Idioma: {$config["idioma"]}<br>";
echo "Contador: $contador";
