<?php

declare(strict_types=1);

namespace Tests;

use App\Precios;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

// Copiad este archivo como tests/PreciosTest.php en el proyecto de herramientas
class PreciosTest extends TestCase
{
    public function testAnadeElIvaGeneral(): void
    {
        $this->assertSame(121.0, Precios::conIva(100));
    }

    public function testUnDescuentoDelCeroPorCienDejaElPrecioIgual(): void
    {
        $this->assertSame(50.0, Precios::conDescuento(50, 0));
    }

    public function testUnDescuentoDelVeintePorCien(): void
    {
        $this->assertSame(40.0, Precios::conDescuento(50, 20));
    }

    public function testRechazaUnDescuentoNegativo(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Precios::conDescuento(50, -10);
    }

    public function testRechazaUnDescuentoMayorQueCien(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Precios::conDescuento(50, 150);
    }
}
