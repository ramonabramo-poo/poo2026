<?php
declare(strict_types=1);

$alumnos = [
    ["nombre" => "Lucía", "curso" => "PHP"],
    ["nombre" => "Pablo", "curso" => "Diseño"],
    ["nombre" => "Marta", "curso" => "PHP"],
    ["nombre" => "Iván", "curso" => "Excel"],
    ["nombre" => "Sara", "curso" => "Diseño"],
];

// Construimos un array nuevo: curso => [nombres]
$porCurso = [];
foreach ($alumnos as $alumno) {
    $porCurso[$alumno["curso"]][] = $alumno["nombre"];
}
ksort($porCurso);

foreach ($porCurso as $curso => $nombres) {
    sort($nombres);
    echo "<strong>$curso</strong> (" . count($nombres) . "): " . implode(", ", $nombres) . "<br>";
}
