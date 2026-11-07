<?php
declare(strict_types=1);

session_start();   // SIEMPRE antes de cualquier HTML

// Si es la primera vez, la "taquilla" está vacía: empezamos en 0
$_SESSION["visitas"] = ($_SESSION["visitas"] ?? 0) + 1;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Contador</title></head>
<body>
    <h1>Has visitado esta página <?= $_SESSION["visitas"] ?> veces</h1>
    <p>Recarga con F5 y verás cómo sube. Ciérrala del todo (navegador incluido) y volverá a empezar.</p>
    <p>Tu identificador de sesión es: <code><?= session_id() ?></code></p>
</body>
</html>
