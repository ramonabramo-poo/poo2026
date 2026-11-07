<?php
// Los errores típicos de esta clase, escritos BIEN.
// Debajo de cada uno tenéis comentada la versión con el error:
// quitad las // y mirad qué mensaje da PHP.

// 1. Olvidar el $
$edad = 25;
// edad = 25;          → Parse error / syntax error

// 2. Guiones o espacios en el nombre
$miVariable = "bien";
// $mi-variable = "mal";  → PHP lo lee como $mi MENOS variable

// 3. echo de un false no muestra NADA
$activo = false;
echo "Con echo: [" . $activo . "]<br>";   // Con echo: []
echo "Con var_dump: ";
var_dump($activo);                          // bool(false)
echo "<br>";

// 4. Usar and / or en lugar de && / ||
$resultado = false || true;    // bool(true), como esperamos
var_dump($resultado);
echo "<br>";
$trampa = false or true;       // ¡bool(false)! El = va antes que el or
var_dump($trampa);
