<?php
// El operador ?? da un valor por defecto si la variable no existe o es null
$apodo = null;
echo $apodo ?? "Sin apodo";    // Sin apodo
echo "<br>";

$ciudad = "Santander";
echo $ciudad ?? "Desconocida"; // Santander
echo "<br>";

// Su uso estrella: leer datos de la URL sin errores
// Probad: 04-null-coalescente.php?nombre=Ana
$nombre = $_GET["nombre"] ?? "invitado";
echo "Hola, " . htmlspecialchars($nombre);
echo "<br>";

// Sin ??, tendríamos que escribir esto:
if (isset($_GET["nombre"])) {
    $nombre2 = $_GET["nombre"];
} else {
    $nombre2 = "invitado";
}
echo "Hola otra vez, " . htmlspecialchars($nombre2);

echo "<hr>";

// El operador ternario: un if/else de una línea
// (condición) ? valor si es verdad : valor si es mentira
$edad = 17;
$mensaje = ($edad >= 18) ? "Pase adelante" : "Acceso denegado";
echo $mensaje;   // Acceso denegado
echo "<br>";

// Muy útil para mostrar un bool de forma legible
$matriculada = true;
echo "Matriculada: " . ($matriculada ? "sí" : "no");
