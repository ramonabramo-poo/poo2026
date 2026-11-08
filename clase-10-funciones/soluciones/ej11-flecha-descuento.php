<?php
declare(strict_types=1);

$precios = [19.99, 45.00, 120.50, 8.75];
$descuento = 0.10;

// Una función flecha "ve" las variables de fuera, como $descuento
$rebajados = array_map(fn (float $precio): float => round($precio * (1 - $descuento), 2), $precios);
$caros = array_filter($precios, fn (float $precio): bool => $precio > 40);

echo "Rebajados: " . implode(" · ", $rebajados) . "<br>";
echo "Más de 40 €: " . implode(" · ", $caros);
