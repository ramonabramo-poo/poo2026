<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/funciones.php";

$titulo = "Productos";
$pagina = "productos";

$productos = [
    ["nombre" => "Camiseta", "precio" => 15],
    ["nombre" => "Gorra", "precio" => 9.5],
    ["nombre" => "Taza", "precio" => 7.95],
];

require __DIR__ . "/includes/cabecera.php";
?>

<h1>Productos</h1>
<ul>
    <?php foreach ($productos as $producto): ?>
        <li><?= e($producto["nombre"]) ?>: <?= euros($producto["precio"]) ?></li>
    <?php endforeach; ?>
</ul>

<?php require __DIR__ . "/includes/pie.php"; ?>
