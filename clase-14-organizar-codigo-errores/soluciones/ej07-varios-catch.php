<?php
declare(strict_types=1);

function repartir(int $caramelos, int $ninos): string
{
    return "Toca a " . intdiv($caramelos, $ninos) . " y sobran " . ($caramelos % $ninos);
}

$casos = [[20, 3], [20, 0], [20, "tres"]];

foreach ($casos as [$caramelos, $ninos]) {
    try {
        echo repartir($caramelos, $ninos) . "<br>";
    } catch (DivisionByZeroError $error) {
        echo "No hay niños: no se puede repartir<br>";
    } catch (TypeError $error) {
        // strict_types: pasar "tres" donde se espera un int es un TypeError
        echo "El número de niños tiene que ser un número entero<br>";
    }
}
