<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

use App\BaseDatos\Conexion;
use App\Repositorios\AlumnoRepositorio;
use App\Repositorios\CursoRepositorio;
use App\Web\Sesion;

$pdo = Conexion::obtener();
$cursosRepo = new CursoRepositorio($pdo);
$alumnosRepo = new AlumnoRepositorio($pdo);   // la MISMA conexión para los dos repositorios
$id = (int) ($_GET["id"] ?? 0);

$curso = $cursosRepo->buscarPorId($id);
if ($curso === null) {
    Sesion::guardarMensaje("Ese curso no existe.", "error");
    redirigir("index.php");
}
$alumnos = $alumnosRepo->delCurso($id);
$titulo = $curso->titulo;

require __DIR__ . "/includes/cabecera.php";
?>

<h1>🎓 <?= e($curso->titulo) ?></h1>
<p>
    <?= $curso->horas ?> horas · <?= euros($curso->precioConIva()) ?> con IVA ·
    <?= $curso->estaCompleto() ? "completo" : "{$curso->plazas} plazas libres" ?>
</p>

<h2>Alumnos matriculados (<?= count($alumnos) ?>)</h2>
<?php if (count($alumnos) === 0): ?>
    <p>Todavía no hay alumnos en este curso.</p>
<?php else: ?>
    <ul>
        <?php foreach ($alumnos as $alumno): ?>
            <li><?= e($alumno->nombre) ?> · <?= e($alumno->email) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p><a href="index.php">← Volver al catálogo</a></p>

<?php require __DIR__ . "/includes/pie.php"; ?>
