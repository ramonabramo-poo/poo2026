<?php
$mensaje = "Hola";

function prueba() {
    echo $mensaje;   // Aviso: $mensaje no existe aquí
}

function pruebaBien($texto) {
    echo $texto;     // Correcto
}

pruebaBien($mensaje);
echo "<br>";
prueba();   // Warning: Undefined variable $mensaje

echo "<hr>";

// Funciones de PHP que usaréis a menudo
echo strlen("Hola"), "<br>";                  // 4
echo strtoupper("php"), "<br>";               // PHP
echo trim("  hola  "), "<br>";                // hola
echo str_replace("a", "o", "casa"), "<br>";   // coso
echo round(3.567, 2), "<br>";                 // 3.57
echo rand(1, 6), "<br>";                      // número aleatorio entre 1 y 6
