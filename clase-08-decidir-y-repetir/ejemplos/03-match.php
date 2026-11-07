<?php
// match: elegir un valor según otro valor
$dia = 6;   // 1 = lunes … 7 = domingo

$tipo = match ($dia) {
    1, 2, 3, 4, 5 => "laborable",
    6, 7          => "fin de semana",
    default       => "día incorrecto",
};
echo "El día $dia es $tipo<br>";

// match (true): elegir según condiciones
$nota = 6.5;
$calificacion = match (true) {
    $nota >= 9 => "Sobresaliente",
    $nota >= 7 => "Notable",
    $nota >= 5 => "Aprobado",
    default    => "Suspenso",
};
echo "Un $nota es un $calificacion";
