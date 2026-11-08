<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

use App\BaseDatos\Conexion;
use App\Excepciones\SinPlazasException;
use App\Repositorios\AlumnoRepositorio;
use App\Repositorios\CursoRepositorio;

$titulo = "Cambiar de curso";
$resultado = "";

$pdo = Conexion::obtener();
$alumnosRepo = new AlumnoRepositorio($pdo);
$cursos = (new CursoRepositorio($pdo))->buscar("", 1, 100);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $alumnosRepo->cambiarDeCurso((int) ($_POST["alumno_id"] ?? 0), (int) ($_POST["curso_id"] ?? 0));
        $resultado = "✅ Cambio hecho.";
    } catch (SinPlazasException $excepcion) {
        $resultado = "❌ " . $excepcion->getMessage();
    }
}

$alumnos = $alumnosRepo->todosConCurso();

require __DIR__ . "/includes/cabecera.php";
?>

<h1>🔀 Cambiar de curso</h1>
<?php if ($resultado !== ""): ?><p><?= e($resultado) ?></p><?php endif; ?>
<form class="formulario" method="post">
    <select name="alumno_id">
        <?php foreach ($alumnos as $alumno): ?>
            <option value="<?= $alumno->id ?>"><?= e($alumno->nombre) ?> (<?= e($alumno->tituloCurso) ?>)</option>
        <?php endforeach; ?>
    </select>
    <select name="curso_id">
        <?php foreach ($cursos as $curso): ?>
            <option value="<?= $curso->id ?>"><?= e($curso->titulo) ?> (<?= $curso->plazas ?> plazas)</option>
        <?php endforeach; ?>
    </select>
    <button class="boton">Cambiar</button>
</form>

<?php require __DIR__ . "/includes/pie.php"; ?>
