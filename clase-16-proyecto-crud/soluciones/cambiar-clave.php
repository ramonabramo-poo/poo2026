<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

$titulo = "Cambiar la contraseña";
$errores = [];

requerirLogin();
$pdo = conectar();
$consulta = $pdo->prepare("SELECT id, clave_hash FROM usuarios WHERE id = :id");
$consulta->execute(["id" => usuarioConectado()["id"]]);
$usuario = $consulta->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    comprobarCsrf($_POST["csrf"] ?? "");
    $actual = $_POST["actual"] ?? "";
    $nueva = $_POST["nueva"] ?? "";

    if (!password_verify($actual, $usuario["clave_hash"])) {
        $errores[] = "La contraseña actual no es correcta.";
    }
    if (strlen($nueva) < 8) {
        $errores[] = "La nueva debe tener al menos 8 caracteres.";
    }
    if ($nueva !== ($_POST["repetida"] ?? "")) {
        $errores[] = "Las contraseñas nuevas no coinciden.";
    }

    if (count($errores) === 0) {
        $actualizar = $pdo->prepare("UPDATE usuarios SET clave_hash = :hash WHERE id = :id");
        $actualizar->execute(["hash" => password_hash($nueva, PASSWORD_DEFAULT), "id" => $usuario["id"]]);
        guardarMensaje("Contraseña cambiada.");
        redirigir("index.php");
    }
}

require __DIR__ . "/includes/cabecera.php";
?>

<h1>🔑 Cambiar la contraseña</h1>
<?php foreach ($errores as $error): ?>
    <p class="error"><?= e($error) ?></p>
<?php endforeach; ?>
<form class="formulario" method="post">
    <input type="hidden" name="csrf" value="<?= tokenCsrf() ?>">
    <label>Contraseña actual <input type="password" name="actual"></label>
    <label>Nueva <input type="password" name="nueva"></label>
    <label>Repite la nueva <input type="password" name="repetida"></label>
    <button class="boton">Cambiar</button>
</form>

<?php require __DIR__ . "/includes/pie.php"; ?>
