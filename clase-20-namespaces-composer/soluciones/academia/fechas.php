<?php
declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

use App\Usuarios\Alumno;
use Carbon\Carbon;

function antiguedad(Alumno $alumno): string
{
    if ($alumno->fechaAlta === null) {
        return "sin fecha de alta";
    }
    return "alta " . Carbon::instance($alumno->fechaAlta)->locale("es")->diffForHumans();
}

date_default_timezone_set("Europe/Madrid");

$alumnos = [
    new Alumno("Marta García", "marta@ejemplo.com", 8.5, new DateTimeImmutable("-2 years -3 months")),
    new Alumno("Luis Pérez", "luis@ejemplo.com", 4.2, new DateTimeImmutable("-5 days")),
    new Alumno("Ana Ruiz", "ana@ejemplo.com", 9.25),
];
$finDeCurso = Carbon::create(2027, 6, 18, 0, 0, 0, "Europe/Madrid");
$hoy = Carbon::today();
?>
<h1>📅 Fechas con Carbon</h1>
<p>Hoy es <?= $hoy->locale("es")->isoFormat("dddd, D [de] MMMM [de] YYYY") ?>.</p>
<p>El curso termina el <?= $finDeCurso->locale("es")->isoFormat("D [de] MMMM") ?>:
    quedan <?= (int) $hoy->diffInDays($finDeCurso) ?> días (<?= (int) $hoy->diffInWeekdays($finDeCurso) ?> laborables).</p>
<ul>
    <?php foreach ($alumnos as $alumno): ?>
        <li><?= htmlspecialchars($alumno->nombre) ?>: <?= antiguedad($alumno) ?></li>
    <?php endforeach; ?>
</ul>
