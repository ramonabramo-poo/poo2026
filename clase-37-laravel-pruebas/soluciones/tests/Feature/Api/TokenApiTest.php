<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// Ejercicio 08: aquí NO usamos Sanctum::actingAs, sino tokens de verdad
class TokenApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function conLosDatosCorrectosSeObtieneUnTokenQueFunciona(): void
    {
        $usuario = User::factory()->create(['email' => 'lucia@example.com']);

        $token = $this->postJson('/api/v1/tokens', [
            'email' => 'lucia@example.com',
            'password' => 'password',
            'dispositivo' => 'portátil',
        ])
            ->assertCreated()
            ->assertJsonPath('tipo', 'Bearer')
            ->json('token');   // json('clave') devuelve ese dato de la respuesta

        $this->withToken($token)   // añade la cabecera Authorization: Bearer ...
            ->getJson('/api/v1/yo')
            ->assertOk()
            ->assertJsonPath('email', 'lucia@example.com');

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $usuario->id,
            'name' => 'portátil',
        ]);
    }

    #[Test]
    public function conLaContraseñaMalNoHayToken(): void
    {
        User::factory()->create(['email' => 'lucia@example.com']);

        $this->postJson('/api/v1/tokens', [
            'email' => 'lucia@example.com',
            'password' => 'mala',
            'dispositivo' => 'portátil',
        ])->assertUnprocessable()->assertJsonValidationErrors('email');

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    #[Test]
    public function unTokenAnuladoDejaDeFuncionar(): void
    {
        $token = User::factory()->create()->createToken('móvil')->plainTextToken;

        $this->withToken($token)->deleteJson('/api/v1/tokens/actual')->assertOk();
        $this->assertDatabaseCount('personal_access_tokens', 0);

        // Laravel recuerda el usuario entre peticiones de la misma prueba: lo olvidamos
        $this->app['auth']->forgetGuards();

        $this->withToken($token)->getJson('/api/v1/yo')->assertUnauthorized();
    }
}
