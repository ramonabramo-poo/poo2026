<?php

namespace App\Servicios;

use App\Contracts\Notificador;
use Illuminate\Support\Facades\Storage;

// Ejercicio 02: otra implementación del mismo contrato
class NotificadorArchivo implements Notificador
{
    public function notificar(string $destinatario, string $asunto, string $mensaje): void
    {
        $linea = sprintf("[%s] Para: %s | %s | %s\n", now()->format('d/m/Y H:i'), $destinatario, $asunto, $mensaje);

        // storage/app/private/notificaciones.txt
        Storage::append('notificaciones.txt', rtrim($linea));
    }
}
