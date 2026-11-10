<?php
$nota = 7.5;

// Con llaves
if ($nota >= 9) {
    echo "Sobresaliente";
} elseif ($nota >= 7) {
    echo "Notable";
} elseif ($nota >= 5) {
    echo "Aprobado";
} else {
    echo "Suspenso";
}

echo "<br>";

// Sintaxis alternativa (hace lo mismo)
if ($nota >= 9):
    echo "Sobresaliente";
elseif ($nota >= 7):
    echo "Notable";
elseif ($nota >= 5):
    echo "Aprobado";
else:
    echo "Suspenso";
endif;

echo "<br>";

// Operador ternario: un if/else en una línea
$edad = 16;
$mensaje = ($edad >= 18) ? "Mayor de edad" : "Menor de edad";
echo $mensaje;
