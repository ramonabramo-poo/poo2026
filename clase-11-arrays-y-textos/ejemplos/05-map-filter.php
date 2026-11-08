<?php
declare(strict_types=1);

$precios = [10, 25, 40];

// array_map: TRANSFORMA cada elemento
$conIva = array_map(fn($p) => $p * 1.21, $precios);
echo implode(" · ", $conIva) . "<br>";   // 12.1 · 30.25 · 48.4

// array_filter: se QUEDA con los que cumplen la condición
$notas = [7, 4, 9, 5, 3];
$aprobadas = array_filter($notas, fn($n) => $n >= 5);
echo implode(", ", $aprobadas) . "<br>";   // 7, 9, 5

// Lo mismo con foreach, para que veáis que no hay magia
$aprobadas2 = [];
foreach ($notas as $n) {
    if ($n >= 5) {
        $aprobadas2[] = $n;
    }
}
echo implode(", ", $aprobadas2);
