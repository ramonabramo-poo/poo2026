<?php
declare(strict_types=1);

// Funciona… pero ¿qué es $d? ¿y $x? ¿y el 0.21?
function calc($a, $d)
{
    $x = 0;
    foreach ($a as $i) {
        $x += $i[1] * $i[2];
    }
    $x = $x - $x * $d / 100;
    return $x + $x * 0.21;
}

$l = [["Teclado", 49.90, 1], ["Ratón", 19.90, 2]];
echo calc($l, 10);
