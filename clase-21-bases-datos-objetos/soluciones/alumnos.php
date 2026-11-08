<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

use App\BaseDatos\Conexion;
use App\Repositorios\AlumnoRepositorio;

$titulo = "Alumnos";

$alumnosRepo = new AlumnoRepositorio(Conexion::obtener());
$alumnos = $alumnosRepo->todosConCurso();

require __DIR__ . "/includes/cabecera.php";
?>

<h1>👥 Alumnos (<?= count($alumnos) ?>)</h1>
<table>
    <tr><th>Nombre</th><th>Email</th><th>Curso</th></tr>
    <?php foreach ($alumnos as $alumno): ?>
        <tr>
            <td><?= e($alumno->nombre) ?></td>
            <td><?= e($alumno->email) ?></td>
            <td><a href="ver.php?id=<?= $alumno->cursoId ?>"><?= e($alumno->tituloCurso) ?></a></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require __DIR__ . "/includes/pie.php"; ?>
