<?php
// La trampa del igual solitario
$x = 3;

if ($x = 10) {          // ❌ NO compara: GUARDA un 10 en $x (y 10 es "verdadero")
    echo "Entra siempre, y ahora \$x vale $x<br>";
}

$y = 3;
if ($y === 10) {        // ✅ Compara
    echo "Esto no se ve";
} else {
    echo "Con === no entra, porque \$y vale $y";
}
