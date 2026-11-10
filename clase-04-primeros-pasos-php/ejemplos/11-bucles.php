<?php
// for con llaves: tabla del 5
for ($i = 1; $i <= 10; $i++) {
    echo "5 x $i = ", 5 * $i, "<br>";
}

echo "<hr>";

// for con sintaxis alternativa
for ($i = 1; $i <= 10; $i++):
    echo "5 x $i = ", 5 * $i, "<br>";
endfor;

echo "<hr>";

// while: repetir mientras se cumpla
$cuenta = 3;
while ($cuenta > 0) {
    echo "Quedan $cuenta<br>";
    $cuenta--;   // ¡sin esta línea, bucle infinito!
}
