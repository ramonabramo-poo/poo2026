<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/funciones.php";

$titulo = "Sobre nosotros";
$pagina = "sobre";

$equipo = [
    ["nombre" => "Ana García", "puesto" => "Dirección"],
    ["nombre" => "Luis Pérez", "puesto" => "Desarrollo"],
];

require __DIR__ . "/includes/cabecera.php";
?>

<h1>Sobre nosotros</h1>
<p>Somos un equipo pequeño con muchas ganas de aprender PHP.</p>
<ul>
    <?php foreach ($equipo as $persona): ?>
        <li><strong><?= e($persona["nombre"]) ?></strong> · <?= e($persona["puesto"]) ?></li>
    <?php endforeach; ?>
</ul>

<?php require __DIR__ . "/includes/pie.php"; ?>
