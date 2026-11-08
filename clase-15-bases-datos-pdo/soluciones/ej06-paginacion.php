<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/includes/conexion.php";
require_once __DIR__ . "/../ejemplos/includes/funciones.php";

const POR_PAGINA = 3;

$pdo = conectar();
$pagina = max(1, (int) ($_GET["pagina"] ?? 1));

$total = (int) $pdo->query("SELECT COUNT(*) FROM alumnos")->fetchColumn();
$paginas = max(1, (int) ceil($total / POR_PAGINA));
$pagina = min($pagina, $paginas);

$consulta = $pdo->prepare("SELECT nombre, ciudad FROM alumnos ORDER BY nombre LIMIT :cuantos OFFSET :desde");
// Con LIMIT y OFFSET hay que decirle a PDO que son enteros
$consulta->bindValue("cuantos", POR_PAGINA, PDO::PARAM_INT);
$consulta->bindValue("desde", ($pagina - 1) * POR_PAGINA, PDO::PARAM_INT);
$consulta->execute();
$alumnos = $consulta->fetchAll();
?>
<h1>Alumnos (página <?= $pagina ?> de <?= $paginas ?>)</h1>
<ul>
    <?php foreach ($alumnos as $alumno): ?>
        <li><?= e($alumno["nombre"]) ?> · <?= e($alumno["ciudad"]) ?></li>
    <?php endforeach; ?>
</ul>
<p>
    <?php for ($i = 1; $i <= $paginas; $i++): ?>
        <?php if ($i === $pagina): ?>
            <strong><?= $i ?></strong>
        <?php else: ?>
            <a href="?pagina=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>
</p>
