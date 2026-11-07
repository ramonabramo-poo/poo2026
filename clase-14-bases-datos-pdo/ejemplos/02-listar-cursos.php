<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/conexion.php";
require_once __DIR__ . "/includes/funciones.php";

$pdo = conectar();

// query() solo cuando la consulta NO lleva ningún dato de fuera
$cursos = $pdo->query("SELECT id, titulo, horas, precio, plazas FROM cursos ORDER BY titulo")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; }
        table { border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: .4rem .8rem; }
        th { background: #0b3d2e; color: white; }
    </style>
</head>
<body>
    <h1>Cursos (<?= count($cursos) ?>)</h1>
    <table>
        <tr><th>Curso</th><th>Horas</th><th>Precio</th><th>Plazas libres</th></tr>
        <?php foreach ($cursos as $curso): ?>
            <tr>
                <td><?= e($curso["titulo"]) ?></td>
                <td><?= $curso["horas"] ?></td>
                <td><?= euros((float) $curso["precio"]) ?></td>
                <td><?= $curso["plazas"] > 0 ? $curso["plazas"] : "Completo" ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
