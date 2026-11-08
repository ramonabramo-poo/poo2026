<?php
declare(strict_types=1);

require __DIR__ . "/vendor/autoload.php";

use Tienda\Catalogo\Categoria;
use Tienda\Catalogo\Producto;
use Tienda\Facturas\Linea as LineaFactura;
use Tienda\Pagos\{Bizum, MetodoPago, Tarjeta};
use Tienda\Pedidos\Linea as LineaPedido;

use function Tienda\euros;

$teclado = new Producto("Teclado", 49.90, Categoria::Informatica, 12);
$cuaderno = new Producto("Cuaderno", 2.50, Categoria::Papeleria, 0);

// Ejercicio 06: dos clases Linea, cada una con su alias
$pedido = [new LineaPedido($teclado, 1), new LineaPedido($cuaderno, 4)];
$total = 0;
foreach ($pedido as $linea) {
    $total += $linea->importe();
    echo "{$linea->unidades} × {$linea->producto->nombre} ({$linea->producto->categoria->etiqueta()}): " . euros($linea->importe()) . "<br>";
}

$factura = new LineaFactura("Pedido web", $total);
echo "Total con IVA: " . euros($factura->total()) . "<br>";

// Ejercicio 08: cualquier método de pago sirve
function pagar(MetodoPago $metodo, float $importe): string
{
    return $metodo->cobrar($importe);
}

echo pagar(new Tarjeta(), $factura->total()) . "<br>";
echo pagar(new Bizum(), 15);
