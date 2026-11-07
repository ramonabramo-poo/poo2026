<?php
declare(strict_types=1);

// Las clases se cargan al principio, igual que los archivos de funciones
require_once __DIR__ . "/clases/Producto.php";

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

// Así llegaban los datos de la base de datos en la clase 14: arrays
$filas = [
    ["nombre" => "Camiseta", "precio" => "15.00", "stock" => 20],
    ["nombre" => "Gorra", "precio" => "9.50", "stock" => 0],
    ["nombre" => "Taza", "precio" => "7.95", "stock" => 3],
];
$productos = [];

// Convertimos cada array en un objeto Producto
foreach ($filas as $fila) {
    $productos[] = Producto::desdeArray($fila);
}
$productos[2]->vender(2);
?>
<ul>
    <?php foreach ($productos as $producto): ?>
        <li>
            <?= htmlspecialchars($producto->nombre) ?>:
            <?= euros($producto->precioConIva()) ?>
            · <?= $producto->hayStock() ? "quedan {$producto->getStock()}" : "agotado" ?>
        </li>
    <?php endforeach; ?>
</ul>
