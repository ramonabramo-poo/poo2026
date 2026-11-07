<?php
declare(strict_types=1);

function esPar(int $numero): bool
{
    return $numero % 2 === 0;
}

for ($i = 1; $i <= 10; $i++) {
    $tipo = esPar($i) ? "par" : "impar";
    echo "{$i} es {$tipo}<br>";
}
