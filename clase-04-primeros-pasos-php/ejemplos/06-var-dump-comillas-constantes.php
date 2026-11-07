<?php
// var_dump(): muestra el tipo y el valor
$precio = 19.99;
var_dump($precio);    // float(19.99)
var_dump("19.99");    // string(5) "19.99"

echo "<hr>";

// Comillas dobles y simples
$nombre = "Ana";
echo "Hola $nombre";   // Hola Ana      → sustituye la variable
echo "<br>";
echo 'Hola $nombre';   // Hola $nombre  → texto literal

echo "<hr>";

// Constantes
const IVA = 0.21;
define("NOMBRE_WEB", "Mi tienda");

$precio = 100;
echo NOMBRE_WEB . ": precio con IVA: " . $precio * (1 + IVA);   // 121
