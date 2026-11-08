<?php
declare(strict_types=1);

// Herramienta para generar el hash de una contraseña.
// Probad: 03-generar-hash.php?clave=1234
$clave = $_GET["clave"] ?? "secreto123";
$hash = password_hash($clave, PASSWORD_DEFAULT);

echo "Contraseña: " . htmlspecialchars($clave) . "<br>";
echo "Hash: <code>" . $hash . "</code><br><br>";

// Recargad la página: ¡el hash cambia cada vez! Y aun así...
var_dump(password_verify($clave, $hash));        // bool(true)
echo "<br>";
var_dump(password_verify("otra cosa", $hash));   // bool(false)
