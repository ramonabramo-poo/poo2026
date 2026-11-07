<?php
declare(strict_types=1);

function calcularMedia(array $notas): float
{
    if (count($notas) === 0) {
        return 0;
    }
    $suma = 0;
    foreach ($notas as $nota) {
        $suma += $nota;
    }
    return round($suma / count($notas), 2);
}

echo calcularMedia([7, 8.5, 6, 9]) . "<br>";   // 7.63
echo calcularMedia([]);                          // 0
