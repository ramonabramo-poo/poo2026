<?php
// Probad: ej11-ternarios.php?nombre=Ana&apodo=&alumnos=1
$nombre = $_GET["nombre"] ?? "invitado";
$apodo = $_GET["apodo"] ?? "";
$alumnos = (int) ($_GET["alumnos"] ?? 0);
$nota = 4.5;

$comoTeLlamo = $apodo ?: $nombre;
$textoAlumnos = $alumnos === 0 ? "no hay alumnos" : "hay " . $alumnos . ($alumnos === 1 ? " alumno" : " alumnos");
$resultado = $nota >= 5 ? "aprobado" : "suspenso";

echo "Hola, $comoTeLlamo<br>";
echo "En el grupo $textoAlumnos<br>";
echo "Con un $nota estás $resultado";
