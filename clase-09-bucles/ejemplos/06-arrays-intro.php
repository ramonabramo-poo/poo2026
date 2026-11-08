<?php
// Introducción a los arrays: una variable que guarda una LISTA de valores
// (en la clase 11 los veremos a fondo)
$frutas = ["manzana", "pera", "plátano"];

// Cada elemento tiene una posición (índice) que EMPIEZA EN 0
echo "La primera: {$frutas[0]}<br>";
echo "La tercera: {$frutas[2]}<br>";

// Añadir al final
$frutas[] = "kiwi";

// count() dice cuántos elementos hay
echo "Hay " . count($frutas) . " frutas<br>";

// print_r() enseña el array entero (muy útil para depurar)
echo "<pre>";
print_r($frutas);
echo "</pre>";
