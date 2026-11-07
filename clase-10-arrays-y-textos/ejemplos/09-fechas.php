<?php
declare(strict_types=1);

// Zona horaria: si no se indica, PHP puede usar la hora UTC (una o dos horas de diferencia)
date_default_timezone_set("Europe/Madrid");

// date(): la fecha de hoy con el formato que queráis
echo date("d/m/Y") . "<br>";          // 06/11/2026
echo date("d/m/Y H:i") . "<br>";      // 06/11/2026 17:45

// DateTime: un objeto que sabe hacer cuentas con fechas
$hoy = new DateTime();
$nacimiento = new DateTime("2000-05-20");

$diferencia = $nacimiento->diff($hoy);
echo "Edad: {$diferencia->y} años<br>";

// Sumar días
$entrega = new DateTime("2026-11-06");
$entrega->modify("+15 days");
echo "Fecha de entrega: " . $entrega->format("d/m/Y");   // 21/11/2026
