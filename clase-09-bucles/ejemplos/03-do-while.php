<?php
// do...while: primero hace y después pregunta, así que se ejecuta AL MENOS una vez
$tiradas = 0;

do {
    $dado = random_int(1, 6);
    $tiradas++;
    echo "Tirada $tiradas: $dado<br>";
} while ($dado !== 6);

echo "¡Un 6! Han hecho falta $tiradas tiradas.";
