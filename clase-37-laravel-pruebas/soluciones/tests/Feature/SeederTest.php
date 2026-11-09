<?php

namespace Tests\Feature;

use App\Enums\Rol;
use App\Models\Alumno;
use App\Models\Categoria;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// Ejercicio 10: ¿los seeders dejan la base de datos como esperamos?
class SeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // seed() ejecuta DatabaseSeeder, como php artisan db:seed
        $this->seed();
    }

    #[Test]
    public function hayUnUsuarioDeCadaRol(): void
    {
        $this->assertDatabaseHas('users', ['email' => 'ramon@academia-alpe.test', 'rol' => Rol::Admin->value]);
        $this->assertSame(1, User::where('rol', Rol::Editor)->count());
        $this->assertSame(1, User::where('rol', Rol::Usuario)->count());
    }

    #[Test]
    public function seCreanLasCategoriasLosCursosYLosAlumnos(): void
    {
        $this->assertSame(3, Categoria::count());
        $this->assertGreaterThanOrEqual(10, Curso::count());
        $this->assertSame(40, Alumno::count());
    }

    #[Test]
    public function ningunCursoTieneMasAlumnosQuePlazas(): void
    {
        foreach (Curso::withCount('alumnos')->get() as $curso) {
            $this->assertLessThanOrEqual($curso->plazas, $curso->alumnos_count, "El curso {$curso->titulo} tiene demasiados alumnos");
        }
    }

    #[Test]
    public function elAdministradorTieneSuPerfil(): void
    {
        $ramon = User::where('email', 'ramon@academia-alpe.test')->firstOrFail();

        $this->assertSame('Santander', $ramon->perfil->ciudad);
    }
}
