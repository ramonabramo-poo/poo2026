<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

use App\BaseDatos\Conexion;
use App\Modelos\Curso;
use App\Repositorios\CursoRepositorio;
use App\Web\Sesion;

$titulo = "Nuevo curso";
$errores = [];
$curso = Curso::vacio();

Sesion::requerirLogin();
$cursosRepo = new CursoRepositorio(Conexion::obtener());
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";

if ($esEnvio) {
    Sesion::comprobarCsrf($_POST["csrf"] ?? "");
    $curso = Curso::desdeFormulario($_POST);
    $errores = $curso->errores();

    if ($curso->esValido()) {
        $cursosRepo->guardar($curso);
        Sesion::guardarMensaje("Curso «{$curso->titulo}» creado con el id {$curso->id}.");
        redirigir("index.php");
    }
}

require __DIR__ . "/includes/cabecera.php";
?>

<h1>➕ Nuevo curso</h1>
<?php require __DIR__ . "/includes/formulario-curso.php"; ?>

<?php require __DIR__ . "/includes/pie.php"; ?>
