<?php
// 5! = 5 × 4 × 3 × 2 × 1 = 120
$numero = 5;
$factorial = 1;     // un acumulador de productos empieza en 1, no en 0
$operacion = "";

for ($i = $numero; $i >= 1; $i--) {
    $factorial *= $i;
    $operacion .= $i . ($i > 1 ? " × " : "");
}

echo "$numero! = $operacion = $factorial";
