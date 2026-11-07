<?php
$alumnos = [
    ["nombre" => "Marta", "nota" => 8.5],
    ["nombre" => "Luis",  "nota" => 4.2],
    ["nombre" => "Ana",   "nota" => 6.8],
    ["nombre" => "Pedro", "nota" => 9.1],
    ["nombre" => "Sara",  "nota" => 3.9],
];

$suma = 0;
$aprobados = 0;
$mejor = $alumnos[0];

foreach ($alumnos as $alumno) {
    $suma += $alumno["nota"];
    if ($alumno["nota"] >= 5) {
        $aprobados++;
    }
    if ($alumno["nota"] > $mejor["nota"]) {
        $mejor = $alumno;
    }
}

echo "Media de la clase: " . round($suma / count($alumnos), 2) . "<br>";
echo "Aprobados: $aprobados<br>";
echo "Mejor nota: {$mejor['nombre']} con un {$mejor['nota']}";
