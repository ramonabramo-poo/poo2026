<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/conexion.php";
require_once __DIR__ . "/includes/funciones.php";

$sql = "SELECT a.nombre, a.email, a.ciudad, a.nota, a.fecha_alta, c.titulo AS curso
        FROM alumnos a
        INNER JOIN cursos c ON a.curso_id = c.id
        WHERE a.id = :id";

// Probad: 04-ficha-alumno.php?id=3
$id = (int) ($_GET["id"] ?? 0);

$pdo = conectar();
$consulta = $pdo->prepare($sql);          // 1. preparar la plantilla
$consulta->execute(["id" => $id]);        // 2. ejecutar con los datos
$alumno = $consulta->fetch();             // 3. recoger UNA fila (o false)

if ($alumno === false) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha del alumno</title>
</head>
<body>
    <?php if ($alumno === false): ?>
        <h1>No existe ningún alumno con el id <?= $id ?></h1>
    <?php else: ?>
        <h1><?= e($alumno["nombre"]) ?></h1>
        <ul>
            <li>Email: <?= e($alumno["email"]) ?></li>
            <li>Ciudad: <?= e($alumno["ciudad"]) ?></li>
            <li>Curso: <?= e($alumno["curso"]) ?></li>
            <li>Nota: <?= e($alumno["nota"] ?? "sin nota") ?></li>
            <li>Alta: <?= date("d/m/Y", strtotime($alumno["fecha_alta"])) ?></li>
        </ul>
    <?php endif; ?>
    <p><a href="03-alumnos-con-curso.php">← Volver al listado</a></p>
</body>
</html>
