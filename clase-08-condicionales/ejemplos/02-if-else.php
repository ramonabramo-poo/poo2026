<?php
// if...else: uno de los dos bloques se ejecuta siempre (nunca los dos)
$numero = 7;

if ($numero % 2 === 0) {
    $tipo = "par";
} else {
    $tipo = "impar";
}

echo "El $numero es $tipo";
