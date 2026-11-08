<?php
$notas = [7, 4, 9, 5, 3, 8];

$aprobados = 0;   // CONTADOR: empieza en 0 y suma 1 cada vez
$suma = 0;        // ACUMULADOR: empieza en 0 y suma el valor

foreach ($notas as $nota) {
    $suma = $suma + $nota;   // o $suma += $nota;
    if ($nota >= 5) {
        $aprobados++;
    }
}

$media = $suma / count($notas);

echo "Notas: " . implode(", ", $notas) . "<br>";
echo "Aprobados: $aprobados de " . count($notas) . "<br>";
echo "Media: " . round($media, 2);
