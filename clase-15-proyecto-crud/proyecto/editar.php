<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

$titulo = "Editar curso";
$errores = [];

requerirLogin();
$pdo = conectar();
$id = (int) ($_GET["id"] ?? 0);
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";

// 1. El curso tiene que existir
$cursoGuardado = obtenerCurso($pdo, $id);
if ($cursoGuardado === null) {
    guardarMensaje("Ese curso no existe.", "error");
    redirigir("index.php");
}

// 2. Al entrar, el formulario se rellena con los datos guardados (precarga)
$curso = $cursoGuardado;

// 3. Al enviar, validamos y actualizamos
if ($esEnvio) {
    comprobarCsrf($_POST["csrf"] ?? "");
    $curso = leerFormularioCurso($_POST);
    $errores = validarCurso($curso);

    if (count($errores) === 0) {
        actualizarCurso($pdo, $id, $curso);
        guardarMensaje("Curso «{$curso['titulo']}» actualizado.");
        redirigir("index.php");
    }
}

require __DIR__ . "/includes/cabecera.php";
?>

<h1>✏️ Editar «<?= e($cursoGuardado["titulo"]) ?>»</h1>
<?php require __DIR__ . "/includes/formulario-curso.php"; ?>

<?php require __DIR__ . "/includes/pie.php"; ?>
