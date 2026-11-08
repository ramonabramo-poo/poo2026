<?php
declare(strict_types=1);

function calificacion(float $nota): string
{
    return match (true) {
        $nota < 0 || $nota > 10 => "Nota no válida",
        $nota >= 9 => "Sobresaliente",
        $nota >= 7 => "Notable",
        $nota >= 5 => "Aprobado",
        default    => "Suspenso",
    };
}

foreach ([9.5, 7, 5, 3.2, 11] as $nota) {
    echo "{$nota}: " . calificacion($nota) . "<br>";
}
