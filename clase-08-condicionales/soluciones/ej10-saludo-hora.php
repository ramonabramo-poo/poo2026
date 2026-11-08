<?php
// date("G") devuelve la hora actual, de 0 a 23
$hora = (int) date("G");

$saludo = match (true) {
    $hora >= 6 && $hora < 14 => "Buenos días",
    $hora >= 14 && $hora < 21 => "Buenas tardes",
    default => "Buenas noches",
};

echo "Son las $hora h. $saludo";
