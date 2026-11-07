<?php

namespace App\Notifications;

use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecordatorioInicioCurso extends Notification
{
    use Queueable;

    public function __construct(
        public Curso $curso,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject("Mañana empieza {$this->curso->titulo}")
            ->greeting("¡Hola, {$notifiable->nombre}!")
            ->line("Te recordamos que mañana empieza el curso «{$this->curso->titulo}».")
            ->action('Ver el curso', route('cursos.show', $this->curso))
            ->line('¡Te esperamos!');
    }
}
