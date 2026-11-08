<?php

declare(strict_types=1);

namespace Tests;

use App\Precios;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

// Cada método que empieza por "test" es una prueba: prepara, ejecuta y COMPRUEBA
class PreciosTest extends TestCase
{
    public function testAnadeElIvaGeneral(): void
    {
        $this->assertSame(121.0, Precios::conIva(100));
    }

    public function testAdmiteOtroTipoDeIva(): void
    {
        $this->assertSame(110.0, Precios::conIva(100, 0.10));
    }

    public function testCalculaElTotalDeVariasLineas(): void
    {
        $lineas = [
            ["precio" => 15.0, "cantidad" => 2],
            ["precio" => 7.95, "cantidad" => 1],
        ];

        $this->assertSame(37.95, Precios::total($lineas));
    }

    public function testUnDescuentoDelCienPorCienDejaElPrecioACero(): void
    {
        $this->assertSame(0.0, Precios::conDescuento(50, 100));
    }

    public function testRechazaUnDescuentoMayorQueCien(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Precios::conDescuento(50, 150);
    }
}
