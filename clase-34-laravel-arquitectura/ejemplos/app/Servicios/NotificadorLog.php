<?php

namespace App\Servicios;

use App\Contracts\Notificador;
use Illuminate\Support\Facades\Log;

// Una implementación del contrato: de momento, apunta las notificaciones en el log
class NotificadorLog implements Notificador
{
    public function notificar(string $destinatario, string $asunto, string $mensaje): void
    {
        Log::info("Notificación para {$destinatario}: {$asunto}", ['mensaje' => $mensaje]);
    }
}
