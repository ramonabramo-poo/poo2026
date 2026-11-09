<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

// Ejercicio 06: solo por la base de datos, para verla en el panel
class ExportacionLista extends Notification
{
    use Queueable;

    // $fichero es null si la exportación ha fallado
    public function __construct(
        public ?string $fichero,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        if ($this->fichero === null) {
            return ['mensaje' => 'La exportación de alumnos ha fallado. Inténtalo más tarde.'];
        }

        return [
            'mensaje' => 'La exportación de alumnos está lista.',
            'enlace' => route('exportaciones.show', $this->fichero),
        ];
    }
}
