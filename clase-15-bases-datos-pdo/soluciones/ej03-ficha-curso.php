<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/includes/conexion.php";
require_once __DIR__ . "/../ejemplos/includes/funciones.php";

$alumnos = [];

// Probad: ej03-ficha-curso.php?id=1
$id = (int) ($_GET["id"] ?? 0);

$pdo = conectar();

$consulta = $pdo->prepare("SELECT titulo, horas, precio, plazas FROM cursos WHERE id = :id");
$consulta->execute(["id" => $id]);
$curso = $consulta->fetch();

if ($curso === false) {
    http_response_code(404);
} else {
    $consulta = $pdo->prepare("SELECT nombre, nota FROM alumnos WHERE curso_id = :id ORDER BY nombre");
    $consulta->execute(["id" => $id]);
    $alumnos = $consulta->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha del curso</title>
</head>
<body>
    <?php if ($curso === false): ?>
        <h1>Ese curso no existe</h1>
    <?php else: ?>
        <h1><?= e($curso["titulo"]) ?></h1>
        <p><?= $curso["horas"] ?> horas · <?= euros((float) $curso["precio"]) ?> · <?= $curso["plazas"] ?> plazas libres</p>

        <h2>Alumnos matriculados (<?= count($alumnos) ?>)</h2>
        <?php if (count($alumnos) === 0): ?>
            <p>Todavía no hay alumnos.</p>
        <?php else: ?>
            <ol>
                <?php foreach ($alumnos as $alumno): ?>
                    <li><?= e($alumno["nombre"]) ?> (<?= e($alumno["nota"] ?? "sin nota") ?>)</li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
