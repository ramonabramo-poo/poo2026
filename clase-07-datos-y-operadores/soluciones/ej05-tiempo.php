<?php
$segundosTotales = 4000;

$horas = intdiv($segundosTotales, 3600);
$resto = $segundosTotales % 3600;
$minutos = intdiv($resto, 60);
$segundos = $resto % 60;

echo "$segundosTotales segundos son $horas h, $minutos min y $segundos s";
// 4000 segundos son 1 h, 6 min y 40 s
