<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/includes/conexion.php";
require_once __DIR__ . "/../ejemplos/includes/funciones.php";

$pdo = conectar();
$medallas = ["🥇", "🥈", "🥉"];

$mejores = $pdo->query(
    "SELECT a.nombre, a.nota, c.titulo
     FROM alumnos a
     INNER JOIN cursos c ON a.curso_id = c.id
     WHERE a.nota IS NOT NULL
     ORDER BY a.nota DESC
     LIMIT 3"
)->fetchAll();
?>
<h1>🏆 Las mejores notas</h1>
<?php foreach ($mejores as $posicion => $alumno): ?>
    <p><?= $medallas[$posicion] ?> <?= e($alumno["nombre"]) ?>: <?= e($alumno["nota"]) ?> en «<?= e($alumno["titulo"]) ?>»</p>
<?php endforeach; ?>
