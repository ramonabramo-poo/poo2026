<?php

namespace Tests\Unit;

use App\Enums\Rol;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

// Ejercicio 04: la misma prueba con varios datos gracias a un "proveedor de datos"
class RolTest extends TestCase
{
    // Cada elemento es una ejecución de la prueba: [valor guardado, rol, etiqueta]
    public static function roles(): array
    {
        return [
            'administrador' => ['admin', Rol::Admin, 'Administrador'],
            'editor' => ['editor', Rol::Editor, 'Editor'],
            'usuario' => ['usuario', Rol::Usuario, 'Usuario'],
        ];
    }

    #[Test]
    #[DataProvider('roles')]
    public function cadaRolTieneSuValorYSuEtiqueta(string $valor, Rol $rol, string $etiqueta): void
    {
        $this->assertSame($rol, Rol::from($valor));
        $this->assertSame($etiqueta, $rol->etiqueta());
    }

    #[Test]
    public function hayTresRoles(): void
    {
        $this->assertCount(3, Rol::cases());
    }

    #[Test]
    public function unValorDesconocidoNoEsUnRol(): void
    {
        // tryFrom() devuelve null en lugar de lanzar una excepción
        $this->assertNull(Rol::tryFrom('superusuario'));

        $this->expectException(\ValueError::class);
        Rol::from('superusuario');
    }
}
