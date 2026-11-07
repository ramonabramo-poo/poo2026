<?php

namespace App\Contracts;

// Un contrato: QUÉ se puede hacer, sin decir CÓMO
interface Notificador
{
    public function notificar(string $destinatario, string $asunto, string $mensaje): void;
}
