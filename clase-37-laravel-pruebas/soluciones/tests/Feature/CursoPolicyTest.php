<?php

namespace Tests\Feature;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// Ejercicio 05: probamos la policy directamente, sin hacer peticiones
class CursoPolicyTest extends TestCase
{
    use RefreshDatabase;

    private Curso $curso;

    protected function setUp(): void
    {
        parent::setUp();

        $this->curso = Curso::factory()->create();
    }

    #[Test]
    public function elAdministradorPuedeConTodo(): void
    {
        $admin = User::factory()->admin()->create();

        // Gate::forUser() pregunta "como si" fuera ese usuario
        $this->assertTrue(Gate::forUser($admin)->allows('create', Curso::class));
        $this->assertTrue(Gate::forUser($admin)->allows('update', $this->curso));
        $this->assertTrue(Gate::forUser($admin)->allows('delete', $this->curso));
    }

    #[Test]
    public function elEditorCreaYEditaPeroNoBorra(): void
    {
        $editora = User::factory()->editor()->create();

        $this->assertTrue($editora->can('create', Curso::class));
        $this->assertTrue($editora->can('update', $this->curso));
        $this->assertTrue($editora->cannot('delete', $this->curso));
    }

    #[Test]
    public function unUsuarioNormalNoPuedeNada(): void
    {
        $usuario = User::factory()->create();

        $this->assertTrue($usuario->cannot('create', Curso::class));
        $this->assertTrue($usuario->cannot('update', $this->curso));
        $this->assertTrue($usuario->cannot('delete', $this->curso));
    }

    #[Test]
    public function laGateDelPanelEsParaAdministradoresYEditores(): void
    {
        $this->assertTrue(User::factory()->admin()->create()->can('ver-panel'));
        $this->assertTrue(User::factory()->editor()->create()->can('ver-panel'));
        $this->assertFalse(User::factory()->create()->can('ver-panel'));
    }
}
