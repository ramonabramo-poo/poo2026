<?php
// elseif: varias opciones. PHP se queda con la PRIMERA condición verdadera
$nota = 7.5;

if ($nota >= 9) {
    $calificacion = "Sobresaliente";
} elseif ($nota >= 7) {
    $calificacion = "Notable";
} elseif ($nota >= 6) {
    $calificacion = "Bien";
} elseif ($nota >= 5) {
    $calificacion = "Suficiente";
} else {
    $calificacion = "Insuficiente";
}

echo "Un $nota es un $calificacion";
