<?php
// Indexado
$colores = ["rojo", "verde", "azul"];
echo $colores[0], "<br>";   // rojo (¡el primero es el 0!)
$colores[] = "negro";       // añade al final

// Asociativo
$alumno = ["nombre" => "Marta", "edad" => 22];
echo $alumno["nombre"], "<br>";   // Marta

foreach ($alumno as $clave => $valor) {
    echo "$clave: $valor<br>";
}

echo "<hr>";

// Arrays dentro de arrays
$alumnos = [
    ["nombre" => "Marta", "nota" => 8],
    ["nombre" => "Luis",  "nota" => 6],
];
foreach ($alumnos as $a) {
    echo $a["nombre"] . " tiene un " . $a["nota"] . "<br>";
}

echo "<hr>";

// Funciones útiles
echo count($colores), "<br>";                                   // 4
echo in_array("rojo", $colores) ? "Hay rojo<br>" : "No hay rojo<br>";
$numeros = [5, 2, 9, 1];
sort($numeros);
echo implode(", ", $numeros), "<br>";                           // 1, 2, 5, 9
echo "<pre>";
print_r($alumno);
echo "</pre>";
