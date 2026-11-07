<?php
$temperaturas = [18, 23, 21, 27, 19, 25, 22];
$dias = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"];

// Truco: suponemos que el máximo es el primero y vamos comparando
$maxima = $temperaturas[0];
$diaMaximo = $dias[0];

for ($i = 1; $i < count($temperaturas); $i++) {
    if ($temperaturas[$i] > $maxima) {
        $maxima = $temperaturas[$i];
        $diaMaximo = $dias[$i];
    }
}

echo "La máxima fue de $maxima ºC, el $diaMaximo";
