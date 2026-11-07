<?php
// Una función flecha es una función pequeñita, de una sola expresión,
// que se guarda en una variable o se pasa a otra función.
$doble = fn($n) => $n * 2;

echo $doble(5) . "<br>";   // 10

// Su uso más habitual: decirle a otra función qué hacer con cada elemento
$precios = [10, 25, 40];
$conIva = array_map(fn($p) => $p * 1.21, $precios);

echo implode(" · ", $conIva);   // 12.1 · 30.25 · 48.4
