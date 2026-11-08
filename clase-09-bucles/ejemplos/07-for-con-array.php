<?php
// Recorrer un array con for: el índice va de 0 a count() - 1
$alumnos = ["Lucía", "Pablo", "Marta", "Iván"];
$total = count($alumnos);

for ($i = 0; $i < $total; $i++) {
    $numero = $i + 1;   // para las personas, la lista empieza en 1
    echo "$numero. {$alumnos[$i]}<br>";
}
