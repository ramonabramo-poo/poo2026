<?php
$numero = -4;

if ($numero === 0) {
    $tipo = "cero";
} elseif ($numero % 2 === 0) {
    $tipo = "par";
} else {
    $tipo = "impar";
}

$signo = $numero > 0 ? "positivo" : ($numero < 0 ? "negativo" : "sin signo");

echo "El $numero es $tipo y $signo";
