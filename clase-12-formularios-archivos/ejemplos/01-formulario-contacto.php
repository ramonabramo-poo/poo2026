<?php
declare(strict_types=1);

// Muestra texto del usuario de forma segura
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

// Devuelve un array con los errores encontrados (vacío si todo está bien)
function validarContacto(string $nombre, string $email, string $mensaje): array
{
    $errores = [];

    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio.";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errores[] = "El email no tiene un formato válido.";
    }
    if (mb_strlen($mensaje) < 10) {
        $errores[] = "El mensaje debe tener al menos 10 caracteres.";
    }

    return $errores;
}

$errores = [];
$enviado = false;

$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$mensaje = trim($_POST["mensaje"] ?? "");

if ($esEnvio) {
    $errores = validarContacto($nombre, $email, $mensaje);
    $enviado = count($errores) === 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto</title>
    <style>
        body { font-family: sans-serif; max-width: 500px; margin: 2rem auto; }
        label { display: block; margin-top: 1rem; }
        input, textarea { width: 100%; padding: .4rem; }
        .errores { color: #b00020; }
        .ok { color: #1b5e20; }
    </style>
</head>
<body>
    <h1>Contacto</h1>

    <?php if ($enviado): ?>
        <p class="ok">¡Gracias, <?= e($nombre) ?>! Te responderemos a <?= e($email) ?>.</p>
    <?php else: ?>

        <?php if (count($errores) > 0): ?>
            <ul class="errores">
                <?php foreach ($errores as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post">
            <label>Nombre
                <input type="text" name="nombre" value="<?= e($nombre) ?>">
            </label>
            <label>Email
                <input type="text" name="email" value="<?= e($email) ?>">
            </label>
            <label>Mensaje
                <textarea name="mensaje" rows="4"><?= e($mensaje) ?></textarea>
            </label>
            <button type="submit">Enviar</button>
        </form>

    <?php endif; ?>
</body>
</html>
