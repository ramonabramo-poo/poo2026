<?php
declare(strict_types=1);

interface Notificador
{
    public function enviar(string $destinatario, string $mensaje): string;
}

class NotificadorEmail implements Notificador
{
    public function enviar(string $destinatario, string $mensaje): string
    {
        return "📧 A {$destinatario}: {$mensaje}";
    }
}

class NotificadorPrueba implements Notificador
{
    public array $enviados = [];

    public function enviar(string $destinatario, string $mensaje): string
    {
        $this->enviados[] = $destinatario;   // no envía nada: solo apunta
        return "🧪 (prueba) a {$destinatario}";
    }
}

// ❌ ANTES: la clase fabrica su propia dependencia con new.
// Imposible cambiarla por otra sin tocar el código de la clase.
class MatriculaRigida
{
    public function confirmar(string $email): string
    {
        $notificador = new NotificadorEmail();
        return $notificador->enviar($email, "¡Matrícula confirmada!");
    }
}

// ✅ DESPUÉS: la dependencia se INYECTA por el constructor.
// La clase dice qué necesita (un Notificador) y otro se lo da.
class Matricula
{
    public function __construct(private Notificador $notificador)
    {
    }

    public function confirmar(string $email): string
    {
        return $this->notificador->enviar($email, "¡Matrícula confirmada!");
    }
}

$deVerdad = new Matricula(new NotificadorEmail());
$deMentira = new Matricula(new NotificadorPrueba());

echo (new MatriculaRigida())->confirmar("marta@ejemplo.com") . "<br>";
echo $deVerdad->confirmar("marta@ejemplo.com") . "<br>";
echo $deMentira->confirmar("marta@ejemplo.com") . "<br>";   // perfecto para hacer pruebas
