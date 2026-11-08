<?php
$peso = 3.5;           // en kilos
$destino = "baleares";
$importeCompra = 45;

$tarifaBase = match ($destino) {
    "peninsula" => 4.95,
    "baleares" => 8.95,
    "canarias", "ceuta", "melilla" => 14.95,
    default => null,
};

if ($tarifaBase === null) {
    $mensaje = "No enviamos a «{$destino}»";
} elseif ($importeCompra >= 50 && $destino === "peninsula") {
    $mensaje = "Envío gratis";
} else {
    // 1 € más por cada kilo (o fracción) a partir de 2 kg
    $extra = $peso > 2 ? ceil($peso - 2) : 0;
    $mensaje = "Envío: " . number_format($tarifaBase + $extra, 2, ",", ".") . " €";
}

echo "$peso kg a $destino: $mensaje";
