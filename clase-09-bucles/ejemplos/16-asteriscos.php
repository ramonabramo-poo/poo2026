<?php
// Bucles anidados para dibujar: el de fuera son las filas; el de dentro, lo que va en cada fila
$filas = 5;

echo "<pre>";
for ($fila = 1; $fila <= $filas; $fila++) {
    for ($estrella = 1; $estrella <= $fila; $estrella++) {
        echo "*";
    }
    echo "\n";
}
echo "</pre>";
