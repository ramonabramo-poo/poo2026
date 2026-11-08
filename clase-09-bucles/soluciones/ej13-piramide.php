<?php
// Una pirámide centrada: en cada fila, primero espacios y después asteriscos
$altura = 5;

echo "<pre>";
for ($fila = 1; $fila <= $altura; $fila++) {
    for ($espacio = 1; $espacio <= $altura - $fila; $espacio++) {
        echo " ";
    }
    for ($estrella = 1; $estrella <= 2 * $fila - 1; $estrella++) {
        echo "*";
    }
    echo "\n";
}
echo "</pre>";
