<?php

namespace Tests\Feature;

use App\Events\AlumnoMatriculado;
use App\Mail\MatriculaConfirmada;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\User;
use App\Notifications\CursoCompleto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// Ejercicio 02: probar eventos, correos y notificaciones sin enviar nada de verdad
class MatriculaTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function alMatricularSeLanzaElEvento(): void
    {
        Event::fake();
        $curso = Curso::factory()->create(['plazas' => 10]);
        $alumno = Alumno::factory()->create();

        $this->actingAs(User::factory()->editor()->create())
            ->post("/cursos/{$curso->id}/matriculas", ['alumno_id' => $alumno->id])
            ->assertSessionHas('exito');

        Event::assertDispatched(AlumnoMatriculado::class, function (AlumnoMatriculado $evento) use ($alumno) {
            return $evento->alumno->is($alumno);
        });
    }

    #[Test]
    public function elAlumnoRecibeElCorreoDeConfirmacion(): void
    {
        // En las pruebas la cola es "sync": el oyente se ejecuta al momento
        Mail::fake();
        $curso = Curso::factory()->create(['plazas' => 10]);
        $alumno = Alumno::factory()->create();

        $this->actingAs(User::factory()->editor()->create())
            ->post("/cursos/{$curso->id}/matriculas", ['alumno_id' => $alumno->id]);

        Mail::assertSent(MatriculaConfirmada::class, fn ($correo) => $correo->hasTo($alumno->email));
    }

    #[Test]
    public function siElCursoSeLlenaSeAvisaAlAdministrador(): void
    {
        Notification::fake();
        $admin = User::factory()->admin()->create();
        $curso = Curso::factory()->create(['plazas' => 1]);

        $this->actingAs($admin)
            ->post("/cursos/{$curso->id}/matriculas", ['alumno_id' => Alumno::factory()->create()->id]);

        Notification::assertSentTo($admin, CursoCompleto::class);
    }

    #[Test]
    public function sinPlazasNoSeMatricula(): void
    {
        $curso = Curso::factory()->create(['plazas' => 1]);
        $curso->alumnos()->attach(Alumno::factory()->create());

        $this->actingAs(User::factory()->editor()->create())
            ->post("/cursos/{$curso->id}/matriculas", ['alumno_id' => Alumno::factory()->create()->id])
            ->assertSessionHas('error');

        $this->assertSame(1, $curso->alumnos()->count());
    }
}
