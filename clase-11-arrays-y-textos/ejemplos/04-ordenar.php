<?php
declare(strict_types=1);

$numeros = [5, 2, 9, 1];
sort($numeros);                    // de menor a mayor
echo implode(", ", $numeros) . "<br>";   // 1, 2, 5, 9
rsort($numeros);                   // de mayor a menor
echo implode(", ", $numeros) . "<br>";   // 9, 5, 2, 1

// Con asociativos, sort() PIERDE las claves. Usad asort() o ksort()
$notas = ["Marta" => 8, "Luis" => 6, "Ana" => 9];

asort($notas);     // ordena por VALOR y conserva las claves
print_r($notas);   // Luis 6, Marta 8, Ana 9
echo "<br>";

arsort($notas);    // por valor, de mayor a menor
print_r($notas);   // Ana 9, Marta 8, Luis 6
echo "<br>";

ksort($notas);     // por CLAVE (orden alfabético)
print_r($notas);   // Ana, Luis, Marta
