<?php
declare(strict_types=1);

// ❌ ANTES: cada descuento nuevo obliga a ABRIR y tocar esta función
function precioConDescuento(float $precio, string $tipo): float
{
    if ($tipo === "estudiante") {
        return $precio * 0.8;
    } elseif ($tipo === "desempleado") {
        return $precio * 0.5;
    } elseif ($tipo === "antiguo-alumno") {
        return $precio - 20;
    }
    return $precio;
}

// ✅ DESPUÉS: abierto a añadir descuentos, cerrado a modificar lo que ya funciona
interface Descuento
{
    public function aplicar(float $precio): float;
}

class DescuentoEstudiante implements Descuento
{
    public function aplicar(float $precio): float
    {
        return $precio * 0.8;
    }
}

class DescuentoDesempleo implements Descuento
{
    public function aplicar(float $precio): float
    {
        return $precio * 0.5;
    }
}

class DescuentoAntiguoAlumno implements Descuento
{
    public function aplicar(float $precio): float
    {
        return max(0, $precio - 20);
    }
}

// Mañana llega «DescuentoFamiliaNumerosa»: una clase nueva y esta función NO se toca
function precioFinal(float $precio, Descuento ...$descuentos): float
{
    foreach ($descuentos as $descuento) {
        $precio = $descuento->aplicar($precio);
    }
    return round($precio, 2);
}

echo precioConDescuento(250, "estudiante") . " €<br>";                                           // 200
echo precioFinal(250, new DescuentoEstudiante()) . " €<br>";                                       // 200
echo precioFinal(250, new DescuentoEstudiante(), new DescuentoAntiguoAlumno()) . " €<br>";         // 180
