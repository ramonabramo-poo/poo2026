<?php

namespace App\Notifications;

use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// Una notificación: un mismo aviso que puede llegar por varios canales
class CursoCompleto extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Curso $curso,
    ) {
    }

    // Por qué canales llega: correo y la tabla notifications (para el panel)
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject("Curso completo: {$this->curso->titulo}")
            ->greeting("Hola, {$notifiable->name}")
            ->line("El curso «{$this->curso->titulo}» ha cubierto sus {$this->curso->plazas} plazas.")
            ->action('Ver el curso', route('cursos.show', $this->curso))
            ->line('Quizá sea el momento de abrir otro grupo. 😉');
    }

    // Lo que se guarda en la columna data de la tabla notifications
    public function toArray(object $notifiable): array
    {
        return [
            'curso_id' => $this->curso->id,
            'mensaje' => "El curso «{$this->curso->titulo}» está completo.",
        ];
    }
}
