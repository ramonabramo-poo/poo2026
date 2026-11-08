<?php
declare(strict_types=1);

// Patrón Factory: un solo sitio decide QUÉ clase se crea a partir de un texto
interface Notificador
{
    public function enviar(string $mensaje): string;
}

class NotificadorEmail implements Notificador
{
    public function enviar(string $mensaje): string
    {
        return "📧 Email: $mensaje";
    }
}

class NotificadorSms implements Notificador
{
    public function enviar(string $mensaje): string
    {
        return "📱 SMS: " . mb_substr($mensaje, 0, 30);
    }
}

class NotificadorTelegram implements Notificador
{
    public function enviar(string $mensaje): string
    {
        return "✈️ Telegram: $mensaje";
    }
}

class FabricaNotificadores
{
    public static function crear(string $canal): Notificador
    {
        return match ($canal) {
            "email" => new NotificadorEmail(),
            "sms" => new NotificadorSms(),
            "telegram" => new NotificadorTelegram(),
            default => throw new InvalidArgumentException("Canal desconocido: $canal"),
        };
    }
}

// Por ejemplo, las preferencias de cada alumno, leídas de la base de datos
$preferencias = ["Lucía" => "email", "Pablo" => "sms", "Marta" => "telegram"];

foreach ($preferencias as $alumno => $canal) {
    echo FabricaNotificadores::crear($canal)->enviar("$alumno, mañana empieza tu curso de PHP") . "<br>";
}
