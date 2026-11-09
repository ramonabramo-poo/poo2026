<?php

namespace App\Servicios;

use App\Contracts\Notificador;

// Ejercicio 08: un Notificador hecho de otros Notificadores.
// Quien lo usa no nota la diferencia: sigue llamando a notificar()
class NotificadorMultiple implements Notificador
{
    /** @param Notificador[] $notificadores */
    public function __construct(private array $notificadores)
    {
    }

    public function notificar(string $destinatario, string $asunto, string $mensaje): void
    {
        foreach ($this->notificadores as $notificador) {
            $notificador->notificar($destinatario, $asunto, $mensaje);
        }
    }
}
