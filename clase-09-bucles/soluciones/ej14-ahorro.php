<?php
// ¿Cuántos meses tardo en reunir el dinero, ahorrando cada mes y con un 1 % de interés mensual?
$objetivo = 1000;
$ahorroMensual = 50;
$interesMensual = 0.01;

$hucha = 0;
$meses = 0;

while ($hucha < $objetivo) {
    $hucha = $hucha * (1 + $interesMensual) + $ahorroMensual;
    $meses++;
}

echo "Necesitas $meses meses: tendrás " . number_format($hucha, 2, ",", ".") . " €";
