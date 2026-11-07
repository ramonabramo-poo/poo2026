<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/conexion.php";
require_once __DIR__ . "/includes/funciones.php";

// Matricular = gastar una plaza del curso + guardar al alumno. O las dos cosas, o ninguna.
function matricular(PDO $pdo, string $nombre, string $email, int $cursoId): void
{
    $pdo->beginTransaction();

    try {
        // 1. Restar una plaza, solo si quedan
        $consulta = $pdo->prepare("UPDATE cursos SET plazas = plazas - 1 WHERE id = :id AND plazas > 0");
        $consulta->execute(["id" => $cursoId]);
        if ($consulta->rowCount() === 0) {
            throw new RuntimeException("No quedan plazas en ese curso.");
        }

        // 2. Guardar al alumno (si el email está repetido, MySQL lanzará una excepción)
        $consulta = $pdo->prepare(
            "INSERT INTO alumnos (nombre, email, curso_id) VALUES (:nombre, :email, :cursoId)"
        );
        $consulta->execute(["nombre" => $nombre, "email" => $email, "cursoId" => $cursoId]);

        $pdo->commit();       // todo ha ido bien: guardamos los dos cambios
    } catch (Throwable $e) {
        $pdo->rollBack();     // algo ha fallado: deshacemos TODO, también la plaza
        throw $e;
    }
}

$mensaje = "";

$pdo = conectar();
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$cursoId = (int) ($_POST["curso_id"] ?? 0);

if ($esEnvio) {
    try {
        matricular($pdo, $nombre, $email, $cursoId);
        $mensaje = "✅ Matrícula completada.";
    } catch (PDOException $e) {
        // PDOException va primero: es un tipo concreto de RuntimeException
        $mensaje = ($e->errorInfo[1] ?? 0) === 1062
            ? "❌ Ya hay un alumno con ese email. No se ha gastado ninguna plaza."
            : "❌ Error en la base de datos: " . $e->getMessage();
    } catch (RuntimeException $e) {
        $mensaje = "❌ " . $e->getMessage();
    }
}

$cursos = $pdo->query("SELECT id, titulo, plazas FROM cursos ORDER BY titulo")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Matrícula</title>
</head>
<body>
    <h1>Matrícula</h1>
    <?php if ($mensaje !== ""): ?>
        <p><strong><?= e($mensaje) ?></strong></p>
    <?php endif; ?>

    <form method="post">
        <p><input name="nombre" placeholder="Nombre" value="<?= e($nombre) ?>"></p>
        <p><input name="email" placeholder="Email" value="<?= e($email) ?>"></p>
        <p>
            <select name="curso_id">
                <?php foreach ($cursos as $curso): ?>
                    <option value="<?= $curso["id"] ?>">
                        <?= e($curso["titulo"]) ?> (<?= $curso["plazas"] ?> plazas)
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <button type="submit">Matricular</button>
    </form>
</body>
</html>
