<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/includes/conexion.php";
require_once __DIR__ . "/../ejemplos/includes/funciones.php";

// Tres cambios que van juntos: liberar plaza, ocupar plaza y cambiar el curso del alumno
function cambiarDeCurso(PDO $pdo, int $alumnoId, int $cursoNuevo): void
{
    $pdo->beginTransaction();

    try {
        $consulta = $pdo->prepare("SELECT curso_id FROM alumnos WHERE id = :id");
        $consulta->execute(["id" => $alumnoId]);
        $cursoActual = $consulta->fetchColumn();

        if ($cursoActual === false) {
            throw new RuntimeException("Ese alumno no existe.");
        }
        if ((int) $cursoActual === $cursoNuevo) {
            throw new RuntimeException("El alumno ya está en ese curso.");
        }

        $consulta = $pdo->prepare("UPDATE cursos SET plazas = plazas - 1 WHERE id = :id AND plazas > 0");
        $consulta->execute(["id" => $cursoNuevo]);
        if ($consulta->rowCount() === 0) {
            throw new RuntimeException("No quedan plazas en el curso nuevo.");
        }

        $consulta = $pdo->prepare("UPDATE cursos SET plazas = plazas + 1 WHERE id = :id");
        $consulta->execute(["id" => $cursoActual]);

        $consulta = $pdo->prepare("UPDATE alumnos SET curso_id = :curso WHERE id = :id");
        $consulta->execute(["curso" => $cursoNuevo, "id" => $alumnoId]);

        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

$mensaje = "";

$pdo = conectar();
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$alumnoId = (int) ($_POST["alumno_id"] ?? 0);
$cursoNuevo = (int) ($_POST["curso_id"] ?? 0);

if ($esEnvio) {
    try {
        cambiarDeCurso($pdo, $alumnoId, $cursoNuevo);
        $mensaje = "✅ Cambio de curso realizado.";
    } catch (RuntimeException $e) {
        $mensaje = "❌ " . $e->getMessage();
    }
}

$alumnos = $pdo->query(
    "SELECT a.id, a.nombre, c.titulo FROM alumnos a INNER JOIN cursos c ON a.curso_id = c.id ORDER BY a.nombre"
)->fetchAll();
$cursos = $pdo->query("SELECT id, titulo, plazas FROM cursos ORDER BY titulo")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar de curso</title>
</head>
<body>
    <h1>Cambiar a un alumno de curso</h1>
    <?php if ($mensaje !== ""): ?>
        <p><strong><?= e($mensaje) ?></strong></p>
    <?php endif; ?>

    <form method="post">
        <select name="alumno_id">
            <?php foreach ($alumnos as $alumno): ?>
                <option value="<?= $alumno["id"] ?>"><?= e($alumno["nombre"]) ?> (<?= e($alumno["titulo"]) ?>)</option>
            <?php endforeach; ?>
        </select>
        →
        <select name="curso_id">
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso["id"] ?>"><?= e($curso["titulo"]) ?> (<?= $curso["plazas"] ?> plazas)</option>
            <?php endforeach; ?>
        </select>
        <button>Cambiar</button>
    </form>
</body>
</html>
