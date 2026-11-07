<?php
declare(strict_types=1);

// ❌ ANTES: una función que lo hace TODO (validar, calcular, formatear)
function procesarPedido(array $pedido): string
{
    if (!isset($pedido["cliente"]) || trim($pedido["cliente"]) === "") {
        return "Error: falta el cliente";
    }
    if (count($pedido["lineas"] ?? []) === 0) {
        return "Error: el pedido está vacío";
    }
    $total = 0;
    foreach ($pedido["lineas"] as $linea) {
        $total += $linea["precio"] * $linea["cantidad"];
    }
    if ($total > 100) {
        $total = $total * 0.9;
    }
    return "Pedido de {$pedido['cliente']}: " . number_format($total, 2, ",", ".") . " €";
}

// ✅ DESPUÉS: cada función hace UNA cosa y su nombre dice cuál
function erroresDelPedido(array $pedido): array
{
    $errores = [];
    if (trim($pedido["cliente"] ?? "") === "") {
        $errores[] = "falta el cliente";
    }
    if (count($pedido["lineas"] ?? []) === 0) {
        $errores[] = "el pedido está vacío";
    }
    return $errores;
}

function subtotal(array $lineas): float
{
    $suma = 0;
    foreach ($lineas as $linea) {
        $suma += $linea["precio"] * $linea["cantidad"];
    }
    return $suma;
}

function aplicarDescuento(float $importe): float
{
    $descuentoDesde = 100;
    return $importe > $descuentoDesde ? $importe * 0.9 : $importe;
}

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

function resumirPedido(array $pedido): string
{
    $errores = erroresDelPedido($pedido);
    if (count($errores) > 0) {
        return "Error: " . implode(", ", $errores);
    }
    return "Pedido de {$pedido['cliente']}: " . euros(aplicarDescuento(subtotal($pedido["lineas"])));
}

$pedido = ["cliente" => "Marta", "lineas" => [["precio" => 60, "cantidad" => 2]]];

echo procesarPedido($pedido) . "<br>";   // Pedido de Marta: 108,00 €
echo resumirPedido($pedido) . "<br>";    // el mismo resultado
echo resumirPedido(["cliente" => ""]) . "<br>";
