<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/clases/Producto.php";
require_once __DIR__ . "/clases/Carrito.php";

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

$camiseta = new Producto("Camiseta", 15, 10);
$gorra = new Producto("Gorra", 9.5, 2);
$taza = new Producto("Taza", 7.95, 5);
$carrito = new Carrito();
$avisos = [];

$carrito->anadir($camiseta, 2);
$carrito->anadir($taza);
$carrito->anadir($gorra, 2);
try {
    $carrito->anadir($gorra);          // ya no quedan más gorras
} catch (RuntimeException $e) {
    $avisos[] = $e->getMessage();
}
$carrito->quitar("Taza");
?>
<h1>🛒 Mi carrito (<?= $carrito->numeroArticulos() ?> artículos)</h1>
<ul>
    <?php foreach ($carrito->getLineas() as $linea): ?>
        <li>
            <?= $linea["unidades"] ?> x <?= htmlspecialchars($linea["producto"]->nombre) ?>
            = <?= euros($linea["producto"]->precioConIva() * $linea["unidades"]) ?>
        </li>
    <?php endforeach; ?>
</ul>
<p><strong>Total: <?= euros($carrito->total()) ?></strong></p>
<?php foreach ($avisos as $aviso): ?>
    <p style="color: #b00020">⚠️ <?= htmlspecialchars($aviso) ?></p>
<?php endforeach; ?>
