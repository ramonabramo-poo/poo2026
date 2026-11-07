<?php
declare(strict_types=1);

namespace App\Notificaciones;

use App\Usuarios\Usuario;

class NotificadorEmail implements Notificador
{
    public function enviar(Usuario $destinatario, string $mensaje): string
    {
        return "📧 A {$destinatario->email}: {$mensaje}";
    }
}
