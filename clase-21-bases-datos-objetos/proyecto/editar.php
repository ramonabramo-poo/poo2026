<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

use App\BaseDatos\Conexion;
use App\Modelos\Curso;
use App\Repositorios\CursoRepositorio;
use App\Web\Sesion;

$titulo = "Editar curso";
$errores = [];

Sesion::requerirLogin();
$cursosRepo = new CursoRepositorio(Conexion::obtener());
$id = (int) ($_GET["id"] ?? 0);
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";

$cursoGuardado = $cursosRepo->buscarPorId($id);
if ($cursoGuardado === null) {
    Sesion::guardarMensaje("Ese curso no existe.", "error");
    redirigir("index.php");
}
$curso = $cursoGuardado;

if ($esEnvio) {
    Sesion::comprobarCsrf($_POST["csrf"] ?? "");
    $curso = Curso::desdeFormulario($_POST, $id);
    $errores = $curso->errores();

    if ($curso->esValido()) {
        $cursosRepo->guardar($curso);
        Sesion::guardarMensaje("Curso «{$curso->titulo}» actualizado.");
        redirigir("index.php");
    }
}

require __DIR__ . "/includes/cabecera.php";
?>

<h1>✏️ Editar «<?= e($cursoGuardado->titulo) ?>»</h1>
<?php require __DIR__ . "/includes/formulario-curso.php"; ?>

<?php require __DIR__ . "/includes/pie.php"; ?>
