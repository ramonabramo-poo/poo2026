<?php

namespace Tests\Feature;

use App\Models\Curso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// Ejercicio 06: la página del presupuesto (clase 35), de principio a fin
class PresupuestoTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function sinDescuentoSoloSumaElIva(): void
    {
        $curso = Curso::factory()->create(['precio' => 200]);

        $this->get("/cursos/{$curso->id}/presupuesto")
            ->assertOk()
            // assertSeeInOrder: estos textos, en este orden
            ->assertSeeInOrder(['200,00 €', '200,00 €', '242,00 €']);
    }

    #[Test]
    public function aplicaElDescuentoAntesDelIva(): void
    {
        $curso = Curso::factory()->create(['precio' => 200]);

        // 200 - 10 % = 180; 180 + 21 % = 217,80
        $this->get("/cursos/{$curso->id}/presupuesto?descuento=10")
            ->assertSeeInOrder(['200,00 €', '180,00 €', '217,80 €']);
    }

    #[Test]
    public function nuncaDescuentaMasDelMaximo(): void
    {
        $curso = Curso::factory()->create(['precio' => 200]);

        // Piden un 90 %, pero el máximo es un 30 %: 140 y 169,40
        $this->get("/cursos/{$curso->id}/presupuesto?descuento=90")
            ->assertSeeInOrder(['200,00 €', '140,00 €', '169,40 €']);
    }

    #[Test]
    public function elMaximoSaleDeLaConfiguracion(): void
    {
        // config() también sirve para CAMBIAR la configuración durante una prueba
        config(['academia.descuento_maximo' => 50]);
        $curso = Curso::factory()->create(['precio' => 200]);

        $this->get("/cursos/{$curso->id}/presupuesto?descuento=90")
            ->assertSee('100,00 €')
            ->assertSee('El descuento máximo es del 50 %.');
    }
}
