<?php
declare(strict_types=1);

session_start();

// En la sesión: cuántas páginas lleva en ESTA visita
$_SESSION["paginas"] = ($_SESSION["paginas"] ?? 0) + 1;

// En la cookie: cuándo vino por última vez (dura 1 año)
$ultimaVisita = $_COOKIE["ultima_visita"] ?? null;
setcookie("ultima_visita", date("d/m/Y H:i"), time() + 365 * 24 * 60 * 60);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Visitas</title></head>
<body>
    <p>Páginas vistas en esta sesión: <?= $_SESSION["paginas"] ?></p>
    <p><?= $ultimaVisita === null ? "¡Es tu primera visita!" : "Tu última visita fue el " . htmlspecialchars($ultimaVisita) ?></p>
    <p>Cerrad el navegador y volved: la sesión empieza de cero, pero la cookie os recuerda.</p>
</body>
</html>
