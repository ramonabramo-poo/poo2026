<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// Ejercicio 07: los middleware de la clase 35
class MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function todasLasRespuestasLlevanLasCabecerasDeSeguridad(): void
    {
        $this->get('/')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('X-Content-Type-Options', 'nosniff');

        // También las de la API, porque el middleware se añadió a todas las peticiones
        $this->getJson('/api/estado')->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }

    #[Test]
    public function laPaginaDelSistemaEsSoloParaElAdministrador(): void
    {
        // Sin sesión: el middleware auth manda al login
        $this->get('/admin/sistema')->assertRedirect('/login');

        // Con sesión pero sin el rol: nuestro middleware rol:admin responde 403
        $this->actingAs(User::factory()->editor()->create())
            ->get('/admin/sistema')
            ->assertForbidden();

        $this->actingAs(User::factory()->admin()->create())
            ->get('/admin/sistema')
            ->assertOk()
            ->assertSee(PHP_VERSION);
    }

    #[Test]
    public function elLoginSeBloqueaTrasCincoIntentos(): void
    {
        for ($intento = 1; $intento <= 5; $intento++) {
            $this->post('/login', ['email' => 'nadie@example.com', 'password' => 'mala'])
                ->assertSessionHasErrors('email');
        }

        // El sexto, en el mismo minuto: 429 Too Many Requests (middleware throttle:5,1)
        $this->post('/login', ['email' => 'nadie@example.com', 'password' => 'mala'])
            ->assertTooManyRequests();
    }
}
