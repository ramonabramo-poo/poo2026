<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// Pruebas de funcionalidad: peticiones HTTP de verdad contra la aplicación entera
class CursoTest extends TestCase
{
    // Cada prueba empieza con la base de datos de pruebas vacía y recién migrada
    use RefreshDatabase;

    // Los datos de un curso válido; cada prueba cambia lo que necesite
    private function datosValidos(array $cambios = []): array
    {
        return array_merge([
            'categoria_id' => Categoria::factory()->create()->id,
            'titulo' => 'Vue.js desde cero',
            'descripcion' => 'Un curso de prueba.',
            'horas' => 40,
            'precio' => 200,
            'plazas' => 15,
            'publicado' => '1',
        ], $cambios);
    }

    #[Test]
    public function elListadoMuestraSoloLosCursosPublicados(): void
    {
        // Preparar
        Curso::factory()->create(['titulo' => 'Python básico', 'publicado' => true]);
        Curso::factory()->sinPublicar()->create(['titulo' => 'Linux avanzado']);

        // Actuar
        $respuesta = $this->get('/cursos');

        // Comprobar
        $respuesta->assertOk();
        $respuesta->assertSee('Python básico');
        $respuesta->assertDontSee('Linux avanzado');
    }

    #[Test]
    public function laFichaDeUnCursoQueNoExisteNoSeEncuentra(): void
    {
        $this->get('/cursos/999')->assertNotFound();
    }

    #[Test]
    public function unInvitadoNoPuedeCrearCursos(): void
    {
        $this->get('/cursos/create')->assertRedirect('/login');
        $this->post('/cursos', $this->datosValidos())->assertRedirect('/login');

        $this->assertDatabaseCount('cursos', 0);
    }

    #[Test]
    public function unUsuarioNormalNoTienePermiso(): void
    {
        $usuario = User::factory()->create();

        $this->actingAs($usuario)
            ->post('/cursos', $this->datosValidos())
            ->assertForbidden();
    }

    #[Test]
    public function unEditorPuedeCrearUnCurso(): void
    {
        $editora = User::factory()->editor()->create();

        $respuesta = $this->actingAs($editora)->post('/cursos', $this->datosValidos());

        $curso = Curso::firstOrFail();
        $respuesta->assertRedirect(route('cursos.show', $curso));
        $respuesta->assertSessionHas('exito');
        $this->assertDatabaseHas('cursos', [
            'titulo' => 'Vue.js desde cero',
            'slug' => 'vuejs-desde-cero',
        ]);
    }

    #[Test]
    public function losDatosIncorrectosNoSeGuardan(): void
    {
        $editora = User::factory()->editor()->create();

        $this->actingAs($editora)
            ->post('/cursos', $this->datosValidos(['titulo' => '', 'horas' => 0, 'precio' => 'gratis']))
            ->assertSessionHasErrors(['titulo', 'horas', 'precio']);

        $this->assertDatabaseCount('cursos', 0);
    }

    #[Test]
    public function seGuardaLaImagenDelCurso(): void
    {
        // Un disco falso: no se escribe nada en storage/ de verdad
        Storage::fake('public');
        $editora = User::factory()->editor()->create();

        $this->actingAs($editora)->post('/cursos', $this->datosValidos([
            'imagen' => UploadedFile::fake()->image('portada.jpg', 800, 500),
        ]));

        $curso = Curso::firstOrFail();
        $this->assertNotNull($curso->imagen);
        Storage::disk('public')->assertExists($curso->imagen);
    }

    #[Test]
    public function unEditorNoPuedeBorrarPeroUnAdministradorSi(): void
    {
        $curso = Curso::factory()->create();

        $this->actingAs(User::factory()->editor()->create())
            ->delete("/cursos/{$curso->id}")
            ->assertForbidden();

        $this->actingAs(User::factory()->admin()->create())
            ->delete("/cursos/{$curso->id}")
            ->assertRedirect('/cursos');

        // Borrado lógico: la fila sigue ahí, con deleted_at
        $this->assertSoftDeleted($curso);
    }
}
