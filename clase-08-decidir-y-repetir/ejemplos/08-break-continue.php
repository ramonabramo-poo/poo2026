<?php
// continue: salta a la siguiente vuelta
echo "Números del 1 al 10 sin los múltiplos de 3: ";
for ($i = 1; $i <= 10; $i++) {
    if ($i % 3 === 0) {
        continue;
    }
    echo "$i ";
}
echo "<br>";

// break: sale del bucle
$productos = ["pan", "leche", "huevos", "café", "fruta"];
$buscado = "huevos";

foreach ($productos as $posicion => $producto) {
    echo "Miro la posición $posicion: $producto<br>";
    if ($producto === $buscado) {
        echo "<strong>¡Encontrado! Dejo de buscar.</strong>";
        break;
    }
}
