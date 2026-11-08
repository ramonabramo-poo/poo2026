<?php

namespace Tests\Feature;

use App\Models\Curso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// El modelo necesita Laravel y la base de datos, así que su prueba va en Feature
class CursoModeloTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function alGuardarElTituloSeGeneraElSlug(): void
    {
        $curso = Curso::factory()->create(['titulo' => '  Diseño web con Figma ']);

        $this->assertSame('Diseño web con Figma', $curso->titulo);
        $this->assertSame('diseno-web-con-figma', $curso->slug);
    }

    #[Test]
    public function calculaElPrecioConIva(): void
    {
        // make() crea el objeto SIN guardarlo: no hace falta tocar la base de datos
        $curso = Curso::factory()->make(['precio' => 100]);

        $this->assertSame(121.0, $curso->precio_con_iva);
    }

    // Ejercicio 01
    #[Test]
    public function elScopePublicadosDescartaLosBorradores(): void
    {
        Curso::factory(2)->create(['publicado' => true]);
        Curso::factory()->sinPublicar()->create();

        $this->assertCount(2, Curso::publicados()->get());
    }

    // Ejercicio 01
    #[Test]
    public function losCursosBorradosNoAparecenPeroSiguenEnLaTabla(): void
    {
        $curso = Curso::factory()->create();

        $curso->delete();

        $this->assertSame(0, Curso::count());
        $this->assertSame(1, Curso::withTrashed()->count());
    }
}
