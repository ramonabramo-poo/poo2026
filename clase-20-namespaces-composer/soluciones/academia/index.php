<?php
declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

use App\Notificaciones\Notificador;
use App\Notificaciones\NotificadorEmail;
use App\Notificaciones\NotificadorSms;
use App\Usuarios\Alumno;
use App\Usuarios\Profesor;

function avisarATodos(Notificador $notificador, array $usuarios, string $mensaje): array
{
    $enviados = [];
    foreach ($usuarios as $usuario) {
        $enviados[] = $notificador->enviar($usuario, $mensaje);
    }
    return $enviados;
}

$usuarios = [
    new Alumno("Marta García", "marta@ejemplo.com", 8.5),
    new Alumno("Luis Pérez", "luis@ejemplo.com", 4.2),
    new Profesor("Ramón Abramo", "ramon@alpe.es", "PHP"),
];
$mensaje = "Mañana empezamos con el MVC. ¡No faltéis!";

$porEmail = avisarATodos(new NotificadorEmail(), $usuarios, $mensaje);
$porSms = avisarATodos(new NotificadorSms(), $usuarios, $mensaje);
?>
<h1>👥 Usuarios</h1>
<ul>
    <?php foreach ($usuarios as $usuario): ?>
        <li><?= htmlspecialchars($usuario->presentarse()) ?></li>
    <?php endforeach; ?>
</ul>

<h2>Avisos enviados</h2>
<ul>
    <?php foreach (array_merge($porEmail, $porSms) as $aviso): ?>
        <li><?= htmlspecialchars($aviso) ?></li>
    <?php endforeach; ?>
</ul>
