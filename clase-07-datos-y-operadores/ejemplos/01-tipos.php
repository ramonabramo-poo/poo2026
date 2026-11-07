<?php
// Cada variable es una caja con una etiqueta ($nombre) y un contenido
$edad = 25;            // int: número entero
$altura = 1.72;        // float: número con decimales (¡con punto!)
$nombre = "Lucía";     // string: texto
$esAlumna = true;      // bool: verdadero o falso
$apodo = null;         // null: la caja existe, pero está vacía

// var_dump() nos enseña el tipo y el valor
var_dump($edad);       // int(25)
echo "<br>";
var_dump($altura);     // float(1.72)
echo "<br>";
var_dump($nombre);     // string(6) "Lucía"  → la tilde ocupa 2 bytes
echo "<br>";
var_dump($esAlumna);   // bool(true)
echo "<br>";
var_dump($apodo);      // NULL
echo "<br>";

// gettype() devuelve el tipo como texto
echo "La variable \$edad es de tipo " . gettype($edad);   // integer
