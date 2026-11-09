<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// Ejercicio 09: componentes y vistas, sin pasar por las rutas
class VistasTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function elComponenteAlertaPoneLaClaseSegunElTipo(): void
    {
        // blade() pinta un trozo de Blade y nos deja comprobar el HTML
        $this->blade('<x-alerta tipo="error">Cuidado</x-alerta>')
            ->assertSee('alerta-error')
            ->assertSee('Cuidado');

        $this->blade('<x-alerta>Hola</x-alerta>')->assertSee('alerta-info');
    }

    #[Test]
    public function elComponenteEscapaElHtml(): void
    {
        $this->blade('<x-alerta>{{ $texto }}</x-alerta>', ['texto' => '<script>alert(1)</script>'])
            ->assertDontSee('<script>', false)    // false: buscar el texto tal cual, sin escapar
            ->assertSee('&lt;script&gt;', false);
    }

    #[Test]
    public function elMenuCambiaSegunQuienEntra(): void
    {
        $this->get('/')
            ->assertSee('Entrar')
            ->assertDontSee('Salir');

        $this->actingAs(User::factory()->create(['name' => 'Pablo']))
            ->get('/')
            ->assertSee('Pablo')
            ->assertSee('Salir')
            ->assertDontSee('>Panel<', false);

        $this->actingAs(User::factory()->editor()->create())
            ->get('/')
            ->assertSee('>Panel<', false);
    }
}
