<?php
// match (PHP 8): elige un VALOR según otro valor, compara con === y no necesita break
$rol = "editor";

$permisos = match ($rol) {
    "admin" => "Control total",
    "editor", "redactor" => "Puede crear y editar contenidos",
    "alumno" => "Acceso a cursos y ejercicios",
    default => "Solo lectura",
};

$dia = 6;   // 1 = lunes … 7 = domingo
$tipoDia = match ($dia) {
    1, 2, 3, 4, 5 => "laborable",
    6, 7 => "fin de semana",
    default => "día incorrecto",
};

echo "Un $rol: $permisos<br>";
echo "El día $dia es $tipoDia";
