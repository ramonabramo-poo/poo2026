<?php
declare(strict_types=1);

// De texto a array
$etiquetas = "php, laragon, mysql, apache";
$lista = explode(", ", $etiquetas);
print_r($lista);   // [0 => php, 1 => laragon, 2 => mysql, 3 => apache]
echo "<br>";

// De array a texto
echo implode(" - ", $lista) . "<br>";   // php - laragon - mysql - apache

// Caso real: una línea de un archivo CSV
$linea = "Marta;García;22;Santander";
$datos = explode(";", $linea);
echo "Nombre: {$datos[0]}, ciudad: {$datos[3]}";
