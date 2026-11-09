<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// Ejercicio 09
class Bienvenida extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('¡Bienvenido a ' . config('app.name') . '!')
            ->greeting("¡Hola, {$notifiable->name}! 👋")
            ->line('Gracias por registrarte. Ya puedes consultar todos nuestros cursos.')
            ->action('Ver los cursos', route('cursos.index'))
            ->line('Si tienes cualquier duda, escríbenos desde la página de contacto.');
    }
}
