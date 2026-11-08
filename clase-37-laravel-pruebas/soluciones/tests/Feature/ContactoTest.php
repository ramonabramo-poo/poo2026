<?php

namespace Tests\Feature;

use App\Contracts\Notificador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

// Ejercicio 02: sustituimos el notificador de verdad por uno falso que solo apunta
class ContactoTest extends TestCase
{
    use RefreshDatabase;

    private object $notificador;

    protected function setUp(): void
    {
        parent::setUp();

        // Una clase anónima que cumple el contrato y guarda lo que le llega
        $this->notificador = new class implements Notificador {
            public array $enviadas = [];

            public function notificar(string $destinatario, string $asunto, string $mensaje): void
            {
                $this->enviadas[] = compact('destinatario', 'asunto', 'mensaje');
            }
        };

        // A partir de aquí, quien pida un Notificador al contenedor recibe el falso
        $this->app->instance(Notificador::class, $this->notificador);
    }

    #[Test]
    public function unMensajeCorrectoSeNotificaALaAcademia(): void
    {
        $this->post('/contacto', [
            'nombre' => 'Ana',
            'email' => 'ana@example.com',
            'mensaje' => 'Quiero información del curso de PHP.',
            'acepto' => '1',
        ])->assertRedirect('/contacto')->assertSessionHas('exito');

        $this->assertCount(1, $this->notificador->enviadas);
        $this->assertSame(config('academia.email'), $this->notificador->enviadas[0]['destinatario']);
        $this->assertStringContainsString('Ana', $this->notificador->enviadas[0]['asunto']);
    }

    #[Test]
    public function unMensajeIncompletoNoSeNotifica(): void
    {
        $this->post('/contacto', ['nombre' => 'Ana', 'email' => 'no-es-un-correo'])
            ->assertSessionHasErrors(['email', 'mensaje', 'acepto']);

        $this->assertCount(0, $this->notificador->enviadas);
    }
}
