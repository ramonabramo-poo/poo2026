<?php
// Bisiesto: divisible entre 4, salvo los divisibles entre 100 que no lo son entre 400
$anio = 2100;

$esBisiesto = ($anio % 4 === 0 && $anio % 100 !== 0) || $anio % 400 === 0;

if ($esBisiesto) {
    echo "$anio es bisiesto: febrero tiene 29 días";
} else {
    echo "$anio no es bisiesto: febrero tiene 28 días";
}
// Pruebas: 2024 (sí), 2023 (no), 1900 (no), 2000 (sí), 2100 (no)
