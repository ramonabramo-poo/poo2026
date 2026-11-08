<?php
declare(strict_types=1);

const NOTA_PARA_APROBAR = 5;

function nombresDeAprobados(array $alumnos): array
{
    $aprobados = array_filter($alumnos, fn(array $alumno) => $alumno["nota"] >= NOTA_PARA_APROBAR);
    return array_column($aprobados, "nombre");
}

function notaMedia(array $alumnos): float
{
    if (count($alumnos) === 0) {
        return 0;
    }
    return array_sum(array_column($alumnos, "nota")) / count($alumnos);
}

$alumnos = [
    ["nombre" => "Marta", "nota" => 8.5],
    ["nombre" => "Luis", "nota" => 4.2],
    ["nombre" => "Ana", "nota" => 9.25],
];

$aprobados = nombresDeAprobados($alumnos);
$media = round(notaMedia($alumnos), 2);

echo "Aprobados: " . implode(", ", $aprobados) . " | Media: {$media}";
