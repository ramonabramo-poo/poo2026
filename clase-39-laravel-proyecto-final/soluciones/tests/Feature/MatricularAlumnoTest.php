<?php

namespace Tests\Feature;

use App\Acciones\MatricularAlumno;
use App\Events\AlumnoMatriculado;
use App\Exceptions\SinPlazasException;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// Ejercicio 10: la acción se prueba directamente, sin peticiones HTTP
class MatricularAlumnoTest extends TestCase
{
    use RefreshDatabase;

    private MatricularAlumno $matricular;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
        // Se la pedimos al contenedor, como haría un controlador
        $this->matricular = app(MatricularAlumno::class);
    }

    #[Test]
    public function matriculaAlAlumnoYLanzaElEvento(): void
    {
        $curso = Curso::factory()->create(['plazas' => 5]);
        $alumno = Alumno::factory()->create();

        $this->matricular->ejecutar($curso, $alumno);

        $this->assertTrue($curso->alumnos()->whereKey($alumno->id)->exists());
        Event::assertDispatched(AlumnoMatriculado::class);
    }

    #[Test]
    public function noMatriculaDosVecesAlMismoAlumno(): void
    {
        $curso = Curso::factory()->create(['plazas' => 5]);
        $alumno = Alumno::factory()->create();
        $this->matricular->ejecutar($curso, $alumno);

        $this->expectException(ValidationException::class);
        $this->matricular->ejecutar($curso, $alumno);
    }

    #[Test]
    public function sinPlazasLanzaSuExcepcionYNoMatricula(): void
    {
        $curso = Curso::factory()->create(['plazas' => 1]);
        $this->matricular->ejecutar($curso, Alumno::factory()->create());
        $otro = Alumno::factory()->create();

        try {
            $this->matricular->ejecutar($curso, $otro);
            $this->fail('Debería haber lanzado SinPlazasException');
        } catch (SinPlazasException) {
            $this->assertSame(1, $curso->alumnos()->count());
            Event::assertDispatchedTimes(AlumnoMatriculado::class, 1);
        }
    }

    #[Test]
    public function elControladorUsaLaAccion(): void
    {
        $curso = Curso::factory()->create(['plazas' => 1]);
        $alumno = Alumno::factory()->create();
        $editora = User::factory()->editor()->create();

        $this->actingAs($editora)
            ->post("/cursos/{$curso->id}/matriculas", ['alumno_id' => $alumno->id])
            ->assertSessionHas('exito');

        // Ya no quedan plazas: SinPlazasException vuelve atrás con el error
        $this->actingAs($editora)
            ->from("/cursos/{$curso->id}")
            ->post("/cursos/{$curso->id}/matriculas", ['alumno_id' => Alumno::factory()->create()->id])
            ->assertRedirect("/cursos/{$curso->id}")
            ->assertSessionHas('error');
    }

    #[Test]
    public function tambienSePuedeMatricularDesdeLaConsola(): void
    {
        $curso = Curso::factory()->create(['plazas' => 5, 'titulo' => 'Vue.js desde cero']);
        $alumno = Alumno::factory()->create();

        $this->artisan('academia:matricular', ['curso' => $curso->id, 'alumno' => $alumno->id])
            ->expectsOutputToContain('Vue.js desde cero')
            ->assertSuccessful();

        $this->artisan('academia:matricular', ['curso' => $curso->id, 'alumno' => $alumno->id])
            ->expectsOutputToContain('ya está matriculado')
            ->assertFailed();
    }
}
