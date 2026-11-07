<?php
declare(strict_types=1);

// Comprueba la foto subida. Devuelve el mensaje de error o "" si es correcta
function validarFoto(?array $foto, array $tiposPermitidos, int $tamanoMaximo): string
{
    if ($foto === null || $foto["error"] !== UPLOAD_ERR_OK) {
        return "No se ha recibido ningún archivo o ha fallado la subida.";
    }
    if ($foto["size"] > $tamanoMaximo) {
        return "La foto no puede pasar de 2 MB.";
    }

    // Comprobamos que de verdad es una imagen mirando su CONTENIDO, no su nombre
    $info = getimagesize($foto["tmp_name"]);
    $tipo = $info["mime"] ?? "";
    if (!isset($tiposPermitidos[$tipo])) {
        return "Solo se permiten imágenes JPG, PNG o WEBP.";
    }

    return "";
}

$tiposPermitidos = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
$tamanoMaximo = 2 * 1024 * 1024;   // 2 MB en bytes
$mensaje = "";
$fotoSubida = "";

$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$foto = $_FILES["foto"] ?? null;

if ($esEnvio) {
    $mensaje = validarFoto($foto, $tiposPermitidos, $tamanoMaximo);

    if ($mensaje === "") {
        // Nombre nuevo y aleatorio: nunca usamos el nombre original
        $tipo = getimagesize($foto["tmp_name"])["mime"];
        $nombreFinal = bin2hex(random_bytes(8)) . "." . $tiposPermitidos[$tipo];
        $destino = __DIR__ . "/uploads/" . $nombreFinal;

        if (move_uploaded_file($foto["tmp_name"], $destino)) {
            $mensaje = "¡Foto subida!";
            $fotoSubida = "uploads/" . $nombreFinal;
        } else {
            $mensaje = "No se ha podido guardar la foto.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir foto</title>
</head>
<body>
    <h1>Subir una foto</h1>

    <?php if ($mensaje !== ""): ?>
        <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
    <?php endif; ?>

    <?php if ($fotoSubida !== ""): ?>
        <img src="<?= $fotoSubida ?>" alt="Foto subida" width="300">
    <?php endif; ?>

    <!-- ¡Sin enctype, el archivo no viaja! -->
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="foto" accept="image/*">
        <button type="submit">Subir</button>
    </form>
</body>
</html>
