<?php
declare(strict_types=1);

// Principio abierto/cerrado: cada forma de envío es una clase nueva
interface MetodoEnvio
{
    public function nombre(): string;
    public function coste(float $pesoKg): float;
}

class EnvioEstandar implements MetodoEnvio
{
    public function nombre(): string
    {
        return "Estándar (3-5 días)";
    }

    public function coste(float $pesoKg): float
    {
        return 4.95 + 0.5 * $pesoKg;
    }
}

class EnvioUrgente implements MetodoEnvio
{
    public function nombre(): string
    {
        return "Urgente (24 h)";
    }

    public function coste(float $pesoKg): float
    {
        return 9.95 + 1.2 * $pesoKg;
    }
}

class RecogidaEnTienda implements MetodoEnvio
{
    public function nombre(): string
    {
        return "Recogida en tienda";
    }

    public function coste(float $pesoKg): float
    {
        return 0;
    }
}

function tablaDeEnvios(float $pesoKg, MetodoEnvio ...$metodos): array
{
    $tabla = [];
    foreach ($metodos as $metodo) {
        $tabla[$metodo->nombre()] = round($metodo->coste($pesoKg), 2);
    }
    return $tabla;
}

$peso = 3;
$tabla = tablaDeEnvios($peso, new EnvioEstandar(), new EnvioUrgente(), new RecogidaEnTienda());

echo "<h2>Envío de un paquete de {$peso} kg</h2><ul>";
foreach ($tabla as $nombre => $coste) {
    echo "<li>{$nombre}: " . number_format($coste, 2, ",", ".") . " €</li>";
}
echo "</ul>";
