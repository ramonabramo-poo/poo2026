<?php
// Probad: ej04-saludo-url.php?nombre=Luis&edad=17
$nombre = $_GET["nombre"] ?? "invitado";
$edad = (int) ($_GET["edad"] ?? 0);

if ($edad === 0) {
    $mensajeEdad = "No sé tu edad.";
} elseif ($edad >= 18) {
    $mensajeEdad = "Eres mayor de edad.";
} else {
    $mensajeEdad = "Te faltan " . (18 - $edad) . " años para ser mayor de edad.";
}

echo "Hola, " . htmlspecialchars($nombre) . "<br>";
echo $mensajeEdad;
