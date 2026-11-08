<?php
// Un número es primo si solo se puede dividir (con resto 0) entre 1 y él mismo
$limite = 50;
$primos = [];

for ($numero = 2; $numero <= $limite; $numero++) {
    $esPrimo = true;

    for ($divisor = 2; $divisor < $numero; $divisor++) {
        if ($numero % $divisor === 0) {
            $esPrimo = false;
            break;   // con un divisor basta: no es primo
        }
    }

    if ($esPrimo) {
        $primos[] = $numero;
    }
}

// implode() junta los elementos del array con el separador que le digamos (clase 11)
echo "Primos hasta $limite: " . implode(", ", $primos);
echo "<br>Hay " . count($primos);
