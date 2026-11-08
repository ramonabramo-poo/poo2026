<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/includes/conexion.php";
require_once __DIR__ . "/../ejemplos/includes/funciones.php";

// LEFT JOIN para que salgan también los cursos sin alumnos; AVG ignora las notas NULL
$sql = "SELECT c.titulo,
               COUNT(a.id) AS alumnos,
               ROUND(AVG(a.nota), 2) AS media,
               MAX(a.nota) AS mejor
        FROM cursos c
        LEFT JOIN alumnos a ON a.curso_id = c.id
        GROUP BY c.id, c.titulo
        ORDER BY c.titulo";

$pdo = conectar();
$filas = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas</title>
</head>
<body>
    <h1>📊 Estadísticas por curso</h1>
    <table border="1" cellpadding="6">
        <tr><th>Curso</th><th>Alumnos</th><th>Nota media</th><th>Mejor nota</th></tr>
        <?php foreach ($filas as $fila): ?>
            <tr>
                <td><?= e($fila["titulo"]) ?></td>
                <td><?= $fila["alumnos"] ?></td>
                <td><?= e($fila["media"] ?? "—") ?></td>
                <td><?= e($fila["mejor"] ?? "—") ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
