<?php
declare(strict_types=1);

// Una función de ayuda para depurar: muestra la variable bien formateada y PARA
function dd(mixed $valor): never
{
    echo "<pre style='background:#222; color:#0f0; padding:1rem'>";
    var_dump($valor);
    echo "</pre>";
    exit;
}

$carrito = [
    ["producto" => "Camiseta", "precio" => 15, "cantidad" => 2],
    ["producto" => "Gorra", "precio" => "9.5", "cantidad" => 1],   // ¡el precio es un texto!
];

$total = 0;
foreach ($carrito as $linea) {
    // ¿El total sale raro? Mirad lo que hay dentro:
    // dd($linea);
    $total += (float) $linea["precio"] * $linea["cantidad"];
}

echo "Total: {$total} €<br>";

// print_r: más legible, pero sin tipos
echo "<pre>";
print_r($carrito);
echo "</pre>";
