<?php
declare(strict_types=1);

namespace App\Notificaciones;

use App\Usuarios\Usuario;

class NotificadorSms implements Notificador
{
    public function enviar(Usuario $destinatario, string $mensaje): string
    {
        return "📱 SMS para {$destinatario->nombre}: " . mb_substr($mensaje, 0, 30);
    }
}
