<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

use App\BaseDatos\Conexion;
use App\Repositorios\UsuarioRepositorio;
use App\Web\Sesion;

$titulo = "Iniciar sesión";
$error = "";

$usuariosRepo = new UsuarioRepositorio(Conexion::obtener());
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$email = trim($_POST["email"] ?? "");
$clave = $_POST["clave"] ?? "";

if (Sesion::usuario() !== null) {
    redirigir("index.php");
}

if ($esEnvio) {
    Sesion::comprobarCsrf($_POST["csrf"] ?? "");
    $usuario = $usuariosRepo->buscarPorEmail($email);

    if ($usuario !== null && $usuario->comprobarClave($clave)) {
        Sesion::entrar($usuario);
        Sesion::guardarMensaje("¡Hola, {$usuario->nombre}!");
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
    <input type="hidden" name="csrf" value="<?= Sesion::tokenCsrf() ?>">
    <label>Email <input type="email" name="email" value="<?= e($email) ?>" required></label>
    <label>Contraseña <input type="password" name="clave" required></label>
    <p><button class="boton">Entrar</button></p>
    <p><small>Usuario de prueba: admin@academia.test / secreto123</small></p>
</form>

<?php require __DIR__ . "/includes/pie.php"; ?>
