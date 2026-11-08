<?php
declare(strict_types=1);

namespace App\Notificaciones;

use App\Usuarios\Usuario;

interface Notificador
{
    public function enviar(Usuario $destinatario, string $mensaje): string;
}
