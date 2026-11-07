<?php
declare(strict_types=1);

$nombre = "  ramón abramo  ";

$limpio = trim($nombre);                  // quita espacios de los extremos
echo "[" . $limpio . "]<br>";             // [ramón abramo]

// Con tildes y eñes, usad SIEMPRE las funciones mb_
echo strlen("Ramón") . "<br>";            // 6  ← cuenta bytes: ¡mal!
echo mb_strlen("Ramón") . "<br>";         // 5  ← cuenta letras: bien

echo mb_strtoupper($limpio) . "<br>";               // RAMÓN ABRAMO
echo mb_convert_case($limpio, MB_CASE_TITLE) . "<br>";   // Ramón Abramo
echo mb_substr("Programación", 0, 7) . "<br>";      // Program

// Buscar (PHP 8)
$email = "ana@mail.es";
var_dump(str_contains($email, "@"));            // bool(true)
var_dump(str_starts_with("https://web.es", "https"));   // bool(true)
var_dump(str_ends_with("foto.jpg", ".pdf"));    // bool(false)
echo "<br>";

// Reemplazar
echo str_replace("mundo", "clase", "Hola, mundo") . "<br>";   // Hola, clase
