<?php
declare(strict_types=1);

// Una INTERFAZ es un contrato: dice qué métodos hay que tener, sin código
interface Notificador
{
    public function enviar(string $destinatario, string $mensaje): string;
}

// Cada clase que «firma» el contrato (implements) está OBLIGADA a cumplirlo
class NotificadorEmail implements Notificador
{
    public function enviar(string $destinatario, string $mensaje): string
    {
        // En una web real aquí se enviaría el correo de verdad
        return "📧 Email a {$destinatario}: {$mensaje}";
    }
}

class NotificadorSms implements Notificador
{
    public function enviar(string $destinatario, string $mensaje): string
    {
        $corto = mb_substr($mensaje, 0, 30);   // los SMS son cortos
        return "📱 SMS a {$destinatario}: {$corto}";
    }
}

class NotificadorTelegram implements Notificador
{
    public function enviar(string $destinatario, string $mensaje): string
    {
        return "✈️ Telegram a @{$destinatario}: {$mensaje}";
    }
}

// Esta función acepta CUALQUIER objeto que cumpla el contrato Notificador
function avisar(Notificador $notificador, string $destinatario): string
{
    return $notificador->enviar($destinatario, "Mañana no hay clase: ¡aprovechad para repasar POO!");
}

echo avisar(new NotificadorEmail(), "marta@ejemplo.com") . "<br>";
echo avisar(new NotificadorSms(), "612345678") . "<br>";
echo avisar(new NotificadorTelegram(), "luis_dev") . "<br>";
