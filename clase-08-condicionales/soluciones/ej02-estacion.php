<?php
$mes = 8;

$estacion = match ($mes) {
    12, 1, 2  => "invierno",
    3, 4, 5   => "primavera",
    6, 7, 8   => "verano",
    9, 10, 11 => "otoño",
    default   => "mes incorrecto",
};

echo "El mes $mes es $estacion";
