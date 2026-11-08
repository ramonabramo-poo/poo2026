<?php
$productos = ["Pan", "Leche", "Huevos", "Tomates", "Aceite de oliva"];
?>
<h1>Lista de la compra</h1>
<ul>
    <?php foreach ($productos as $producto): ?>
        <li><?= $producto ?></li>
    <?php endforeach; ?>
</ul>
