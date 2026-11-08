<?php
declare(strict_types=1);

// Una "tabla" de productos: un array que contiene arrays
$catalogo = [
    ["id" => 1, "nombre" => "Portátil", "precio" => 899.00, "stock" => 3],
    ["id" => 2, "nombre" => "Monitor",  "precio" => 299.50, "stock" => 0],
    ["id" => 3, "nombre" => "Teclado",  "precio" => 49.90,  "stock" => 12],
];

// Fila 0, columna "nombre"
echo $catalogo[0]["nombre"] . "<br>";   // Portátil
echo "Hay " . count($catalogo) . " productos<br>";
?>
<table border="1" cellpadding="6">
    <tr><th>Producto</th><th>Precio</th><th>Disponibilidad</th></tr>
    <?php foreach ($catalogo as $producto): ?>
        <tr>
            <td><?= $producto["nombre"] ?></td>
            <td><?= number_format($producto["precio"], 2, ",", ".") ?> €</td>
            <td><?= $producto["stock"] > 0 ? "En stock" : "Agotado" ?></td>
        </tr>
    <?php endforeach; ?>
</table>
