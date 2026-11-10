<?php
// Aritméticos
echo 7 + 2, "<br>";    // 9
echo 7 - 2, "<br>";    // 5
echo 7 * 2, "<br>";    // 14
echo 7 / 2, "<br>";    // 3.5
echo 7 % 2, "<br>";    // 1 (resto)
echo 7 ** 2, "<br>";   // 49 (potencia)

echo "<hr>";

// Asignación
$x = 10;    // asigna
$x += 5;    // $x = $x + 5  → 15
$x++;       // suma 1       → 16
echo $x, "<br>";

// Concatenación: el punto une textos
$saludo = "Hola, " . "Pedro";   // Hola, Pedro
$saludo .= "!";                  // añade al final → Hola, Pedro!
echo $saludo, "<hr>";

// Comparación (var_dump muestra true o false)
var_dump(5 == "5");    // true:  igual valor
var_dump(5 === "5");   // false: igual valor y tipo
var_dump(5 !== "5");   // true:  distinto valor o tipo
var_dump(5 >= 5);      // true
