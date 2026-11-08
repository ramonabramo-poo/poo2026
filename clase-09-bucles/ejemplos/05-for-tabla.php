<?php
// La tabla de multiplicar de un número
$tabla = 7;

echo "<h2>Tabla del $tabla</h2>";
for ($i = 1; $i <= 10; $i++) {
    $resultado = $tabla * $i;
    echo "$tabla × $i = $resultado<br>";
}
