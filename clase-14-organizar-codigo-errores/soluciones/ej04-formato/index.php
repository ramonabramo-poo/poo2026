<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/formato.php";
// Un segundo require_once no vuelve a cargarlo (con require daría "Cannot redeclare function")
require_once __DIR__ . "/includes/formato.php";

$pedido = [
    "cliente" => "Lucía <Pérez>",
    "fecha" => "2026-11-08",
    "total" => 1234.5,
];
?>
<p>Cliente: <?= e($pedido["cliente"]) ?></p>
<p>Fecha: <?= fechaEs($pedido["fecha"]) ?></p>
<p>Total: <?= euros($pedido["total"]) ?></p>
