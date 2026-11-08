<?php
// Contar las cifras de un número y darle la vuelta, quitando la última cifra en cada vuelta
$numero = 90817;
$queda = $numero;
$cifras = 0;
$alReves = 0;

do {
    $ultima = $queda % 10;               // la última cifra
    $alReves = $alReves * 10 + $ultima;
    $queda = intdiv($queda, 10);         // quitamos la última cifra
    $cifras++;
} while ($queda > 0);

echo "$numero tiene $cifras cifras y al revés es $alReves";
