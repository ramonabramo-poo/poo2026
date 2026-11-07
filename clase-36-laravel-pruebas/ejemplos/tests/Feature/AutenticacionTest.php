<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AutenticacionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function unUsuarioPuedeIniciarSesion(): void
    {
        $usuario = User::factory()->create(['email' => 'lucia@example.com']);

        $this->post('/login', [
            'email' => 'lucia@example.com',
            'password' => 'password',  // la contraseña de UserFactory
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($usuario);
    }

    #[Test]
    public function conLaContraseñaMalNoEntra(): void
    {
        User::factory()->create(['email' => 'lucia@example.com']);

        $this->post('/login', ['email' => 'lucia@example.com', 'password' => 'mala'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    #[Test]
    public function alRegistrarseSeCifraLaContraseñaYSeIniciaLaSesion(): void
    {
        $this->post('/registro', [
            'name' => 'Lucía',
            'email' => 'lucia@example.com',
            'password' => 'secreta123',
            'password_confirmation' => 'secreta123',
        ])->assertRedirect('/');

        $usuario = User::where('email', 'lucia@example.com')->firstOrFail();
        $this->assertNotSame('secreta123', $usuario->password);
        $this->assertAuthenticatedAs($usuario);
    }

    #[Test]
    public function unUsuarioPuedeCerrarLaSesion(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }
}
