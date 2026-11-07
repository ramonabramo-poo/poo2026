<?php
$nombre = "Marta";
$edad = 22;
$nota = 7.5;
$matriculada = true;

echo "<h2>Ficha del alumno</h2>";
echo "Nombre: $nombre (" . gettype($nombre) . ")<br>";
echo "Edad: $edad (" . gettype($edad) . ")<br>";
echo "Nota: $nota (" . gettype($nota) . ")<br>";
echo "Matriculada: " . ($matriculada ? "sí" : "no") . " (" . gettype($matriculada) . ")<br>";
