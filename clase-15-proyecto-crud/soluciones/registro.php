<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

function validarRegistro(string $nombre, string $email, string $clave, string $clave2): array
{
    $errores = [];
    if (mb_strlen($nombre) < 2) {
        $errores["nombre"] = "Escribe tu nombre.";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errores["email"] = "El email no es válido.";
    }
    if (mb_strlen($clave) < 8) {
        $errores["clave"] = "La contraseña debe tener al menos 8 caracteres.";
    } elseif ($clave !== $clave2) {
        $errores["clave"] = "Las contraseñas no coinciden.";
    }
    return $errores;
}

function crearUsuario(PDO $pdo, string $nombre, string $email, string $clave): void
{
    $consulta = $pdo->prepare("INSERT INTO usuarios (nombre, email, clave_hash) VALUES (:nombre, :email, :hash)");
    $consulta->execute([
        "nombre" => $nombre,
        "email" => $email,
        "hash" => password_hash($clave, PASSWORD_DEFAULT),
    ]);
}

$titulo = "Crear cuenta";
$errores = [];

$pdo = conectar();
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$clave = $_POST["clave"] ?? "";
$clave2 = $_POST["clave2"] ?? "";

if ($esEnvio) {
    comprobarCsrf($_POST["csrf"] ?? "");
    $errores = validarRegistro($nombre, $email, $clave, $clave2);

    if (count($errores) === 0) {
        try {
            crearUsuario($pdo, $nombre, $email, $clave);
            guardarMensaje("Cuenta creada. Ya puedes iniciar sesión.");
            redirigir("login.php");
        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? 0) !== 1062) {
                throw $e;
            }
            $errores["email"] = "Ya existe una cuenta con ese email.";
        }
    }
}

require __DIR__ . "/includes/cabecera.php";
?>

<h1>📝 Crear cuenta</h1>
<form method="post" class="formulario">
    <input type="hidden" name="csrf" value="<?= tokenCsrf() ?>">
    <label>Nombre <input name="nombre" value="<?= e($nombre) ?>"></label>
    <small class="error"><?= e($errores["nombre"] ?? "") ?></small>
    <label>Email <input type="email" name="email" value="<?= e($email) ?>"></label>
    <small class="error"><?= e($errores["email"] ?? "") ?></small>
    <label>Contraseña <input type="password" name="clave"></label>
    <label>Repite la contraseña <input type="password" name="clave2"></label>
    <small class="error"><?= e($errores["clave"] ?? "") ?></small>
    <p><button class="boton">Crear cuenta</button></p>
</form>

<?php require __DIR__ . "/includes/pie.php"; ?>
