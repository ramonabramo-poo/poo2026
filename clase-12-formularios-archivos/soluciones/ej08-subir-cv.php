<?php
declare(strict_types=1);

function validarCv(?array $archivo, int $tamanoMaximo): string
{
    if ($archivo === null || $archivo["error"] !== UPLOAD_ERR_OK) {
        return "No se ha recibido ningún archivo.";
    }
    if ($archivo["size"] > $tamanoMaximo) {
        return "El CV no puede pasar de 2 MB.";
    }
    // El tipo real, mirando el contenido del archivo (no su extensión)
    $tipo = mime_content_type($archivo["tmp_name"]);
    if ($tipo !== "application/pdf") {
        return "Solo se admiten archivos PDF.";
    }

    return "";
}

$tamanoMaximo = 2 * 1024 * 1024;
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cv = $_FILES["cv"] ?? null;
    $mensaje = validarCv($cv, $tamanoMaximo);

    if ($mensaje === "") {
        $nombreFinal = date("Ymd-His") . "-" . bin2hex(random_bytes(4)) . ".pdf";
        $mensaje = move_uploaded_file($cv["tmp_name"], __DIR__ . "/cv/" . $nombreFinal)
            ? "CV recibido. ¡Gracias!"
            : "No se ha podido guardar el archivo.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Envía tu CV</title></head>
<body>
    <h1>Trabaja con nosotros</h1>
    <?php if ($mensaje !== ""): ?>
        <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="cv" accept="application/pdf">
        <button>Enviar</button>
    </form>
</body>
</html>
