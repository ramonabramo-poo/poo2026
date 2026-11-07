<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

$titulo = "Nuevo curso";
$errores = [];
$curso = ["titulo" => "", "horas" => 20, "precio" => 0, "plazas" => 20];

requerirLogin();
$pdo = conectar();
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";

if ($esEnvio) {
    comprobarCsrf($_POST["csrf"] ?? "");
    $curso = leerFormularioCurso($_POST);
    $errores = validarCurso($curso);

    if (count($errores) === 0) {
        crearCurso($pdo, $curso);
        guardarMensaje("Curso «{$curso['titulo']}» creado.");
        redirigir("index.php");
    }
}

require __DIR__ . "/includes/cabecera.php";
?>

<h1>➕ Nuevo curso</h1>
<?php require __DIR__ . "/includes/formulario-curso.php"; ?>

<?php require __DIR__ . "/includes/pie.php"; ?>
