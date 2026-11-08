<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Curso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// Ejercicio 03: los comandos de Artisan también se prueban
class ComandosTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function avisaSiNoHayCursosEnLaCategoria(): void
    {
        $this->artisan('academia:cursos', ['--categoria' => 'no-existe'])
            ->expectsOutput('No hay cursos en esa categoría.')
            ->assertSuccessful();
    }

    #[Test]
    public function muestraLosCursosDeLaCategoria(): void
    {
        $diseno = Categoria::factory()->create(['nombre' => 'Diseño', 'slug' => 'diseno']);
        Curso::factory()->for($diseno)->create(['titulo' => 'Photoshop básico']);

        $this->artisan('academia:cursos', ['--categoria' => 'diseno'])
            ->expectsOutputToContain('Photoshop básico')
            ->assertSuccessful();
    }

    #[Test]
    public function lasEstadisticasCuentanLosCursos(): void
    {
        Curso::factory(3)->create();

        $this->artisan('academia:estadisticas')
            ->expectsOutput('Cursos: 3')
            ->assertSuccessful();
    }
}
