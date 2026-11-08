<?php
// Cada número es la suma de los dos anteriores: 0, 1, 1, 2, 3, 5, 8…
$cuantos = 15;
$anterior = 0;
$actual = 1;
$serie = [$anterior, $actual];

for ($i = 3; $i <= $cuantos; $i++) {
    $siguiente = $anterior + $actual;
    $serie[] = $siguiente;
    $anterior = $actual;
    $actual = $siguiente;
}

// implode() junta los elementos del array separados por comas (clase 11)
echo implode(", ", $serie);
