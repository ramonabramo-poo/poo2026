<?php

namespace Tests\Unit;

use App\Servicios\CalculadoraPrecios;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

// Prueba unitaria: una clase sola, sin Laravel, sin base de datos. Muy rápida.
class CalculadoraPreciosTest extends TestCase
{
    private CalculadoraPrecios $calculadora;

    // Se ejecuta antes de CADA prueba: cada una empieza con una calculadora nueva
    protected function setUp(): void
    {
        parent::setUp();

        $this->calculadora = new CalculadoraPrecios(iva: 0.21, descuentoMaximo: 30);
    }

    #[Test]
    public function sumaElIva(): void
    {
        $this->assertSame(121.0, $this->calculadora->conIva(100));
    }

    #[Test]
    public function redondeaADosDecimales(): void
    {
        $this->assertSame(12.1, $this->calculadora->conIva(9.999));
    }

    #[Test]
    public function aplicaElDescuento(): void
    {
        $this->assertSame(90.0, $this->calculadora->conDescuento(100, 10));
    }

    #[Test]
    public function noPermiteMasDescuentoDelMaximo(): void
    {
        // Piden un 80 %, pero el máximo es un 30 %
        $this->assertSame(70.0, $this->calculadora->conDescuento(100, 80));
    }

    #[Test]
    public function formateaComoEnEspaña(): void
    {
        $this->assertSame('1.234,50 €', $this->calculadora->formatear(1234.5));
    }
}
