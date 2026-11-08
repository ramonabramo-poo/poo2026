<?php
$a = 12;
$b = 45;
$c = 45;

if ($a >= $b && $a >= $c) {
    $mayor = $a;
} elseif ($b >= $a && $b >= $c) {
    $mayor = $b;
} else {
    $mayor = $c;
}

// ¿Hay empate en el primer puesto? Si el mayor coincide con dos de ellos, sí
$empate = ($mayor === $a && $mayor === $b) || ($mayor === $a && $mayor === $c) || ($mayor === $b && $mayor === $c);

echo "El mayor de $a, $b y $c es $mayor";
echo $empate ? " (y está repetido)" : "";
