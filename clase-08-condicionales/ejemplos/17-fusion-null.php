<?php
// ?? (fusión de null): usa lo de la izquierda si EXISTE y no es null
// Probad: 17-fusion-null.php?ciudad=Santander&puntos=0
$puntosPorDefecto = 10;

$ciudad = $_GET["ciudad"] ?? "sin ciudad";
$puntos = $_GET["puntos"] ?? $puntosPorDefecto;

// Encadenado: el primero que exista
$idioma = $_GET["idioma"] ?? $_GET["lang"] ?? "es";

echo "Ciudad: $ciudad<br>";
echo "Puntos: $puntos<br>";   // con ?puntos=0 da 0; con ?: daría 10
echo "Idioma: $idioma";
