<?php
declare(strict_types=1);

$temas = ["claro" => ["#ffffff", "#222222"], "oscuro" => ["#1e1e1e", "#eeeeee"], "sepia" => ["#f4ecd8", "#5b4636"]];
$tamanos = ["pequeña" => 14, "normal" => 17, "grande" => 21];
$unMes = time() + 30 * 24 * 60 * 60;

if (isset($_GET["restablecer"])) {
    // Para borrar una cookie, se envía con una fecha ya pasada
    setcookie("tema", "", time() - 3600);
    setcookie("letra", "", time() - 3600);
    header("Location: ej10-preferencias.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $temaElegido = $_POST["tema"] ?? "";
    $letraElegida = $_POST["letra"] ?? "";
    // Solo guardamos valores de nuestra lista
    if (isset($temas[$temaElegido])) {
        setcookie("tema", $temaElegido, $unMes);
    }
    if (isset($tamanos[$letraElegida])) {
        setcookie("letra", $letraElegida, $unMes);
    }
    header("Location: ej10-preferencias.php");
    exit;
}

// Lo que llega en la cookie también lo comprobamos: la puede cambiar el usuario
$tema = isset($temas[$_COOKIE["tema"] ?? ""]) ? $_COOKIE["tema"] : "claro";
$letra = isset($tamanos[$_COOKIE["letra"] ?? ""]) ? $_COOKIE["letra"] : "normal";
[$fondo, $texto] = $temas[$tema];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Preferencias</title>
    <style>
        body { background: <?= $fondo ?>; color: <?= $texto ?>; font-size: <?= $tamanos[$letra] ?>px; }
    </style>
</head>
<body>
    <h1>Mis preferencias</h1>
    <form method="post">
        <select name="tema">
            <?php foreach ($temas as $nombre => $colores): ?>
                <option <?= $nombre === $tema ? "selected" : "" ?>><?= $nombre ?></option>
            <?php endforeach; ?>
        </select>
        <select name="letra">
            <?php foreach ($tamanos as $nombre => $px): ?>
                <option <?= $nombre === $letra ? "selected" : "" ?>><?= $nombre ?></option>
            <?php endforeach; ?>
        </select>
        <button>Guardar</button>
        <a href="?restablecer=1">Restablecer</a>
    </form>
</body>
</html>
