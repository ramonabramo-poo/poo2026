<?php
function calcularMedia(array $notas): float
{
    if (count($notas) === 0) {
        return 0;
    }

    $suma = 0;
    foreach ($notas as $nota) {
        $suma += $nota;
    }

    return $suma / count($notas);
}

$alumnos = [
    "Marta" => [8.5, 9, 7],
    "Luis" => [6, 5.5, 4],
    "Ana" => [9.5, 10, 9],
];

foreach ($alumnos as $nombre => $notas) {
    $media = calcularMedia($notas);
    echo "$nombre: " . number_format($media, 2, ",", ".") . "<br>";
}
