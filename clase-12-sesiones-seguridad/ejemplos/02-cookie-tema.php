<?php
declare(strict_types=1);

$temas = ["claro", "oscuro"];

$temaElegido = $_GET["tema"] ?? "";
$tema = $_COOKIE["tema"] ?? "claro";

// Si el usuario elige un tema válido, lo guardamos en una cookie durante 30 días
if (in_array($temaElegido, $temas, true)) {
    setcookie("tema", $temaElegido, [
        "expires" => time() + 60 * 60 * 24 * 30,   // dentro de 30 días
        "path" => "/",
        "httponly" => true,                        // JavaScript no puede leerla
        "samesite" => "Lax",
    ]);
    header("Location: 02-cookie-tema.php");   // recargamos para que la cookie ya llegue
    exit;
}

// Nunca nos fiamos de una cookie: el usuario puede cambiarla
if (!in_array($tema, $temas, true)) {
    $tema = "claro";
}
$fondo = $tema === "oscuro" ? "#1e1e1e" : "#ffffff";
$texto = $tema === "oscuro" ? "#eeeeee" : "#222222";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tema</title>
    <style>
        body { background: <?= $fondo ?>; color: <?= $texto ?>; font-family: sans-serif; padding: 2rem; }
        a { color: #4f7cff; }
    </style>
</head>
<body>
    <h1>Tema actual: <?= $tema ?></h1>
    <p><a href="?tema=claro">Tema claro</a> · <a href="?tema=oscuro">Tema oscuro</a></p>
    <p>Cerrad el navegador y volved a abrir la página: el tema se recuerda.</p>
</body>
</html>
