<?php
declare(strict_types=1);

$texto = "El curso de PHP es práctico. En el curso hacemos ejercicios, y los ejercicios del curso tienen solución.";

$limpio = mb_strtolower(str_replace([".", ","], "", $texto));
$palabras = explode(" ", $limpio);

// Las palabras cortas (el, de, y…) no nos interesan
$palabras = array_filter($palabras, fn (string $palabra): bool => mb_strlen($palabra) > 3);

// array_count_values cuenta cuántas veces aparece cada valor
$frecuencias = array_count_values($palabras);
arsort($frecuencias);

echo "<ol>";
foreach (array_slice($frecuencias, 0, 3) as $palabra => $veces) {
    echo "<li>$palabra: $veces " . ($veces === 1 ? "vez" : "veces") . "</li>";
}
echo "</ol>";
