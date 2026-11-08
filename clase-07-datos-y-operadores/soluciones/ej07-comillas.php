<?php
$curso = "PHP";
$horas = 60;
$alumno = ["nombre" => "Lucía", "nota" => 8.5];

// Tres formas de escribir la misma frase
echo 'Lucía hace el curso de ' . $curso . ' (' . $horas . ' horas)<br>';
echo "Lucía hace el curso de $curso ($horas horas)<br>";
echo "{$alumno["nombre"]} hace el curso de {$curso} ({$horas} horas)<br>";

// Las comillas simples no sustituyen variables
echo 'Con simples: $curso<br>';
echo "Con dobles: $curso";
