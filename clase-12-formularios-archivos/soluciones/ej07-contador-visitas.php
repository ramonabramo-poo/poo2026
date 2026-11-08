<?php
declare(strict_types=1);

$archivo = __DIR__ . "/datos/visitas.txt";

// Si el archivo no existe todavía, empezamos en 0
$visitas = file_exists($archivo) ? (int) file_get_contents($archivo) : 0;
$visitas++;
file_put_contents($archivo, (string) $visitas, LOCK_EX);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Visitas</title></head>
<body>
    <h1>Eres la visita número <?= number_format($visitas, 0, ",", ".") ?> 🎉</h1>
    <p>Recarga la página y verás cómo sube.</p>
</body>
</html>
