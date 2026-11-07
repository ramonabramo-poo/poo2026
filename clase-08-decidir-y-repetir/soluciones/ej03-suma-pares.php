<?php
$suma = 0;
$cuantos = 0;

for ($i = 1; $i <= 100; $i++) {
    if ($i % 2 === 0) {
        $suma += $i;
        $cuantos++;
    }
}

echo "Hay $cuantos pares entre 1 y 100 y suman $suma";   // 50 y 2550
