<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

$titulo = "Estadísticas";
$pdo = conectar();

$resumen = $pdo->query(
    "SELECT COUNT(*) AS cursos,
            SUM(plazas) AS plazas_libres,
            AVG(precio) AS precio_medio,
            SUM(plazas = 0) AS completos
     FROM cursos"
)->fetch();
$masCaro = $pdo->query("SELECT titulo, precio FROM cursos ORDER BY precio DESC LIMIT 1")->fetch();
$alumnosPorCurso = $pdo->query(
    "SELECT c.titulo, COUNT(a.id) AS alumnos
     FROM cursos c
     LEFT JOIN alumnos a ON a.curso_id = c.id
     GROUP BY c.id, c.titulo
     ORDER BY alumnos DESC"
)->fetchAll();

require __DIR__ . "/includes/cabecera.php";
?>

<h1>📊 Estadísticas</h1>
<ul>
    <li>Cursos: <?= $resumen["cursos"] ?></li>
    <li>Plazas libres en total: <?= $resumen["plazas_libres"] ?></li>
    <li>Precio medio: <?= euros((float) $resumen["precio_medio"]) ?></li>
    <li>Cursos completos: <?= $resumen["completos"] ?></li>
    <?php if ($masCaro): ?>
        <li>El más caro: <?= e($masCaro["titulo"]) ?> (<?= euros((float) $masCaro["precio"]) ?>)</li>
    <?php endif; ?>
</ul>

<h2>Alumnos por curso</h2>
<table>
    <?php foreach ($alumnosPorCurso as $fila): ?>
        <tr><td><?= e($fila["titulo"]) ?></td><td><?= $fila["alumnos"] ?></td></tr>
    <?php endforeach; ?>
</table>

<?php require __DIR__ . "/includes/pie.php"; ?>
