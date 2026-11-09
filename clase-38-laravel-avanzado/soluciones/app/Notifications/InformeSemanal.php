<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// Ejercicio 04
class InformeSemanal extends Notification implements ShouldQueue
{
    use Queueable;

    // $cursos: un array sencillo con los datos de cada curso, y no los modelos.
    // ¿Por qué? Al ir a la cola, los modelos se guardan solo con su id y se vuelven
    // a leer de la base de datos al enviar... y perderíamos el alumnos_count
    public function __construct(
        public array $cursos,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $correo = (new MailMessage())
            ->subject('Informe semanal: ' . count($this->cursos) . ' cursos empiezan esta semana')
            ->greeting("Hola, {$notifiable->name}");

        if ($this->cursos === []) {
            return $correo->line('Esta semana no empieza ningún curso. ¡Semana tranquila!');
        }

        foreach ($this->cursos as $curso) {
            $correo->line("• {$curso['titulo']}: empieza el {$curso['fecha']}, "
                . "{$curso['alumnos']} de {$curso['plazas']} plazas ocupadas.");
        }

        return $correo->action('Ir al panel', route('admin.panel'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'mensaje' => 'Informe semanal: ' . count($this->cursos) . ' cursos empiezan esta semana.',
        ];
    }
}
