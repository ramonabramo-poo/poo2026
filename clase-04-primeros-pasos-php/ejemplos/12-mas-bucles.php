<?php
// foreach: recorrer un array
$frutas = ["manzana", "pera", "uva"];

foreach ($frutas as $fruta) {
    echo "$fruta<br>";
}

echo "<hr>";

foreach ($frutas as $fruta):
    echo "$fruta<br>";
endforeach;

echo "<hr>";

// do...while: se ejecuta al menos una vez
$n = 10;
do {
    echo "Se ejecuta una vez aunque la condición sea falsa<br>";
} while ($n < 5);

echo "<hr>";

// break y continue
for ($i = 1; $i <= 10; $i++) {
    if ($i % 2 == 0) continue;   // salta los pares
    if ($i > 7) break;           // termina al pasar de 7
    echo "$i ";                  // 1 3 5 7
}
