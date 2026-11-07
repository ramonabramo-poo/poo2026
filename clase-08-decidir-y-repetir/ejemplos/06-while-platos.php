<?php
$platosEnPila = 3;

while ($platosEnPila > 0) {
    echo "Fregando un plato. Quedan {$platosEnPila}<br>";
    $platosEnPila--;   // ¡sin esta línea, no acabaríais nunca!
}

echo "¡Pila limpia!";
