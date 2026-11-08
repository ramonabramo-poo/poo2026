<?php
declare(strict_types=1);

// UNA sola línea carga nuestras clases (PSR-4) y las librerías instaladas
require_once __DIR__ . "/vendor/autoload.php";

use App\Modelos\Pedido;
use App\Modelos\Producto;
use App\Servicios\Formato;
use Carbon\Carbon;

date_default_timezone_set("Europe/Madrid");

$pedidoAntiguo = new Pedido(1001, Carbon::now()->subDays(3));
$pedidoAntiguo->anadir(new Producto("Camiseta", 15), 2);

$pedidoNuevo = new Pedido(1002, Carbon::now()->subHours(2));
$pedidoNuevo->anadir(new Producto("Taza", 7.95));
$pedidoNuevo->anadir(new Producto("Gorra", 9.5), 3);

$pedidos = [$pedidoAntiguo, $pedidoNuevo];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
</head>
<body>
    <h1>📦 Pedidos</h1>
    <ul>
        <?php foreach ($pedidos as $pedido): ?>
            <li>
                Pedido <?= $pedido->numero ?> (<?= $pedido->haceCuanto() ?>):
                <?= Formato::euros($pedido->total()) ?>
                · entrega prevista el <?= $pedido->fechaEntrega() ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
