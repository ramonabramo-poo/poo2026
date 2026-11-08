<?php
declare(strict_types=1);

// El PADRE se carga primero: Alumno y Profesor lo necesitan para existir
require_once __DIR__ . "/clases/Usuario.php";
require_once __DIR__ . "/clases/Alumno.php";
require_once __DIR__ . "/clases/Profesor.php";

$usuarios = [
    new Alumno("Marta García", "marta@ejemplo.com", 8.5),
    new Alumno("Luis Pérez", "luis@ejemplo.com", 4.2),
    new Profesor("Ramón Abramo", "ramon@alpe.es", "PHP"),
];
?>
<ul>
    <?php foreach ($usuarios as $usuario): ?>
        <li><?= htmlspecialchars($usuario->presentarse()) ?></li>
    <?php endforeach; ?>
</ul>
