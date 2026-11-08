<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

session_start();
$_SESSION["csrf"] ??= bin2hex(random_bytes(32));
$_SESSION["comentarios"] ??= [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // CSRF: el formulario tiene que traer nuestro token
    if (!hash_equals($_SESSION["csrf"], $_POST["csrf"] ?? "")) {
        http_response_code(403);
        exit("Petición no autorizada.");
    }
    $comentario = trim($_POST["comentario"] ?? "");
    if ($comentario !== "") {
        $_SESSION["comentarios"][] = $comentario;   // guardamos el texto TAL CUAL
    }
    header("Location: ej09-comentarios-seguros.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Comentarios</title></head>
<body>
    <form method="post">
        <input type="hidden" name="csrf" value="<?= $_SESSION["csrf"] ?>">
        <textarea name="comentario" placeholder="Probad a escribir <script>alert('hola')</script>"></textarea>
        <button>Comentar</button>
    </form>
    <ul>
        <?php foreach ($_SESSION["comentarios"] as $comentario): ?>
            <!-- XSS: escapamos AL MOSTRAR -->
            <li><?= e($comentario) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
