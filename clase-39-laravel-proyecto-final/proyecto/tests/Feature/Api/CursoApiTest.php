<?php

namespace Tests\Feature\Api;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CursoApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function elListadoDevuelveLosCursosPaginados(): void
    {
        Curso::factory(3)->create(['publicado' => true]);

        $this->getJson('/api/v1/cursos?por_pagina=2')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('meta.total', 3)
            ->assertJsonStructure([
                'data' => [['id', 'titulo', 'precio', 'categoria' => ['nombre']]],
                'links',
                'meta',
            ]);
    }

    #[Test]
    public function sinTokenNoSePuedeCrear(): void
    {
        $this->postJson('/api/v1/cursos', [])
            ->assertUnauthorized()
            ->assertJson(['mensaje' => 'Necesitas un token válido.']);
    }

    #[Test]
    public function conTokenDeEditorSeCreaUnCurso(): void
    {
        // Sanctum::actingAs simula una petición con el token de ese usuario
        Sanctum::actingAs(User::factory()->editor()->create());
        $categoria = Categoria::factory()->create();

        $this->postJson('/api/v1/cursos', [
            'categoria_id' => $categoria->id,
            'titulo' => 'Vue.js desde cero',
            'horas' => 40,
            'precio' => 200,
            'plazas' => 15,
        ])
            ->assertCreated()
            ->assertJsonPath('data.titulo', 'Vue.js desde cero')
            ->assertJsonPath('data.precio_con_iva', 242);

        $this->assertDatabaseHas('cursos', ['slug' => 'vuejs-desde-cero']);
    }

    #[Test]
    public function losDatosIncorrectosSeRechazanConSusErrores(): void
    {
        Sanctum::actingAs(User::factory()->editor()->create());

        $this->postJson('/api/v1/cursos', ['titulo' => 'Ab'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['titulo', 'categoria_id', 'horas']);
    }

    #[Test]
    public function soloElAdministradorPuedeBorrar(): void
    {
        $curso = Curso::factory()->create();

        Sanctum::actingAs(User::factory()->editor()->create());
        $this->deleteJson("/api/v1/cursos/{$curso->id}")->assertForbidden();

        Sanctum::actingAs(User::factory()->admin()->create());
        $this->deleteJson("/api/v1/cursos/{$curso->id}")->assertNoContent();

        $this->assertSoftDeleted($curso);
    }
}
