<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

function obtenerAlumnosDelCurso(PDO $pdo, int $cursoId): array
{
    $consulta = $pdo->prepare("SELECT nombre, email FROM alumnos WHERE curso_id = :id ORDER BY nombre");
    $consulta->execute(["id" => $cursoId]);
    return $consulta->fetchAll();
}

$pdo = conectar();
$id = (int) ($_GET["id"] ?? 0);

$curso = obtenerCurso($pdo, $id);
if ($curso === null) {
    guardarMensaje("Ese curso no existe.", "error");
    redirigir("index.php");
}
$alumnos = obtenerAlumnosDelCurso($pdo, $id);
$titulo = $curso["titulo"];

require __DIR__ . "/includes/cabecera.php";
?>

<h1>🎓 <?= e($curso["titulo"]) ?></h1>
<p><?= $curso["horas"] ?> horas · <?= euros((float) $curso["precio"]) ?> · <?= $curso["plazas"] ?> plazas libres</p>

<h2>Alumnos matriculados (<?= count($alumnos) ?>)</h2>
<?php if (count($alumnos) === 0): ?>
    <p>Todavía no hay alumnos en este curso.</p>
<?php else: ?>
    <ul>
        <?php foreach ($alumnos as $alumno): ?>
            <li><?= e($alumno["nombre"]) ?> · <?= e($alumno["email"]) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p><a href="index.php">← Volver al catálogo</a></p>

<?php require __DIR__ . "/includes/pie.php"; ?>
