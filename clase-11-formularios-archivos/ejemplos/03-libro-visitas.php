<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

// Lee las visitas guardadas; si el archivo no existe todavía, devuelve un array vacío
function leerVisitas(string $archivo): array
{
    if (!file_exists($archivo)) {
        return [];
    }
    return json_decode(file_get_contents($archivo), true) ?? [];
}

// Guarda todo el array como JSON
function guardarVisitas(string $archivo, array $visitas): void
{
    $json = json_encode($visitas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($archivo, $json, LOCK_EX);
}

date_default_timezone_set("Europe/Madrid");
$archivo = __DIR__ . "/datos/visitas.json";
$error = "";

$visitas = leerVisitas($archivo);
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$nombre = trim($_POST["nombre"] ?? "");
$texto = trim($_POST["texto"] ?? "");
$gracias = isset($_GET["ok"]);

if ($esEnvio) {
    if ($nombre === "" || $texto === "") {
        $error = "Rellena los dos campos.";
    } else {
        // Añadir la nueva visita al principio y guardar
        array_unshift($visitas, [
            "nombre" => $nombre,
            "texto" => $texto,
            "fecha" => date("d/m/Y H:i"),
        ]);
        guardarVisitas($archivo, $visitas);

        // Post/Redirect/Get: redirigimos para que F5 no vuelva a enviar el formulario
        header("Location: 03-libro-visitas.php?ok=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libro de visitas</title>
</head>
<body>
    <h1>Libro de visitas</h1>

    <?php if ($gracias): ?>
        <p style="color: green">¡Gracias por firmar!</p>
    <?php endif; ?>

    <?php if ($error !== ""): ?>
        <p style="color: red"><?= e($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="nombre" placeholder="Tu nombre">
        <input type="text" name="texto" placeholder="Tu mensaje">
        <button type="submit">Firmar</button>
    </form>

    <h2>Firmas: <?= count($visitas) ?></h2>
    <?php foreach ($visitas as $visita): ?>
        <p>
            <strong><?= e($visita["nombre"]) ?></strong>
            <small>(<?= e($visita["fecha"]) ?>)</small><br>
            <?= e($visita["texto"]) ?>
        </p>
    <?php endforeach; ?>
</body>
</html>
