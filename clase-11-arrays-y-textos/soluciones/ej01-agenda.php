<?php
declare(strict_types=1);

$contactos = [
    ["nombre" => "Marta", "telefono" => "612345678", "ciudad" => "Santander"],
    ["nombre" => "Luis",  "telefono" => "698765432", "ciudad" => "Bilbao"],
    ["nombre" => "Ana",   "telefono" => "655443322", "ciudad" => "Santander"],
];

$contactos[] = ["nombre" => "Pedro", "telefono" => "677889900", "ciudad" => "Oviedo"];

echo "<h2>Agenda (" . count($contactos) . " contactos)</h2><ul>";
foreach ($contactos as $c) {
    echo "<li>{$c['nombre']} · {$c['telefono']} · {$c['ciudad']}</li>";
}
echo "</ul>";

$deSantander = array_filter($contactos, fn($c) => $c["ciudad"] === "Santander");
echo "De Santander: " . count($deSantander);
