<?php
$filas = 5;

echo "<pre>";
for ($fila = 1; $fila <= $filas; $fila++) {
    for ($i = 1; $i <= $fila; $i++) {
        echo "*";
    }
    echo "\n";
}
echo "</pre>";
