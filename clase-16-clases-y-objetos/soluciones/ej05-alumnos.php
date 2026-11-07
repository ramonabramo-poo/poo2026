<?php
declare(strict_types=1);

require_once __DIR__ . "/clases/Alumno.php";

function calcularMedia(array $alumnos): float
{
    $conNota = array_filter($alumnos, fn(Alumno $alumno) => $alumno->tieneNota());
    if (count($conNota) === 0) {
        return 0;
    }
    $suma = array_sum(array_map(fn(Alumno $alumno) => $alumno->getNota(), $conNota));
    return round($suma / count($conNota), 2);
}

// Filas como las que devolvería un SELECT de la tabla alumnos de la clase 14
$filas = [
    ["id" => 1, "nombre" => "Marta García", "nota" => "8.50"],
    ["id" => 2, "nombre" => "Luis Pérez", "nota" => "4.20"],
    ["id" => 3, "nombre" => "Ana Ruiz", "nota" => "9.25"],
    ["id" => 4, "nombre" => "Carlos Díaz", "nota" => null],
];

$alumnos = array_map(fn(array $fila) => Alumno::desdeArray($fila), $filas);
$aprobados = array_filter($alumnos, fn(Alumno $alumno) => $alumno->haAprobado());
$media = calcularMedia($alumnos);
?>
<h1>Notas de la clase</h1>
<ul>
    <?php foreach ($alumnos as $alumno): ?>
        <li>
            <?= htmlspecialchars($alumno->nombre) ?>:
            <?= $alumno->tieneNota() ? $alumno->getNota() : "sin nota" ?>
            <?= $alumno->haAprobado() ? "✅" : "" ?>
        </li>
    <?php endforeach; ?>
</ul>
<p>Aprobados: <?= count($aprobados) ?> · Nota media: <?= $media ?></p>
