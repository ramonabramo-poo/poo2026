<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/conexion.php";
require_once __DIR__ . "/includes/funciones.php";

$sql = "SELECT a.id, a.nombre, a.email, a.nota, c.titulo AS curso
        FROM alumnos a
        INNER JOIN cursos c ON a.curso_id = c.id
        ORDER BY a.nombre";

$pdo = conectar();
$alumnos = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumnos</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; }
        table { border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: .4rem .8rem; }
        th { background: #0b3d2e; color: white; }
    </style>
</head>
<body>
    <h1>Alumnos y su curso</h1>
    <table>
        <tr><th>Nombre</th><th>Email</th><th>Curso</th><th>Nota</th></tr>
        <?php foreach ($alumnos as $alumno): ?>
            <tr>
                <td><a href="04-ficha-alumno.php?id=<?= $alumno["id"] ?>"><?= e($alumno["nombre"]) ?></a></td>
                <td><?= e($alumno["email"]) ?></td>
                <td><?= e($alumno["curso"]) ?></td>
                <td><?= $alumno["nota"] === null ? "Sin nota" : e($alumno["nota"]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
