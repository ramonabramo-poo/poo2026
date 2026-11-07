<?php

namespace App\Servicios;

use App\Contracts\Notificador;
use App\Mail\MensajeContacto;
use Illuminate\Support\Facades\Mail;

// Ejercicio 01: la implementación por correo del contrato de la clase 34
class NotificadorCorreo implements Notificador
{
    public function notificar(string $destinatario, string $asunto, string $mensaje): void
    {
        Mail::to($destinatario)->send(new MensajeContacto($asunto, $mensaje));
    }
}
