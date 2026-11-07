<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

$titulo = "Iniciar sesión";
$error = "";

$pdo = conectar();
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$email = trim($_POST["email"] ?? "");
$clave = $_POST["clave"] ?? "";

if (usuarioConectado() !== null) {
    redirigir("index.php");
}

if ($esEnvio) {
    comprobarCsrf($_POST["csrf"] ?? "");
    $usuario = buscarUsuarioPorEmail($pdo, $email);

    if ($usuario !== null && password_verify($clave, $usuario["clave_hash"])) {
        session_regenerate_id(true);
        // En la sesión, solo lo necesario: nunca el hash de la contraseña
        $_SESSION["usuario"] = ["id" => $usuario["id"], "nombre" => $usuario["nombre"]];
        guardarMensaje("¡Hola, {$usuario['nombre']}!");
        redirigir("index.php");
    }

    $error = "Email o contraseña incorrectos.";
}

require __DIR__ . "/includes/cabecera.php";
?>

<h1>🔐 Iniciar sesión</h1>
<?php if ($error !== ""): ?>
    <p class="mensaje error"><?= e($error) ?></p>
<?php endif; ?>

<form method="post" class="formulario">
    <input type="hidden" name="csrf" value="<?= tokenCsrf() ?>">
    <label>Email <input type="email" name="email" value="<?= e($email) ?>" required></label>
    <label>Contraseña <input type="password" name="clave" required></label>
    <p><button class="boton">Entrar</button></p>
    <p><small>Usuario de prueba: admin@academia.test / secreto123</small></p>
</form>

<?php require __DIR__ . "/includes/pie.php"; ?>
