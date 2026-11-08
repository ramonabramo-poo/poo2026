<?php
declare(strict_types=1);

// Las funciones que trabajan con el alumno andan sueltas por el código
function haAprobado(array $alumno): bool
{
    return $alumno["nota"] >= 5;
}

$alumno = ["nombre" => "Marta", "nota" => 8.5];

// Con arrays sueltos, nadie impide que los datos se estropeen
$alumno["nota"] = 15;          // ¿un 15 sobre 10? PHP no protesta
$alumno["nomber"] = "Luis";    // una errata crea una clave nueva, sin avisar

echo "<pre>";
print_r($alumno);
echo "</pre>";
var_dump(haAprobado($alumno));   // bool(true)... ¡con un 15!
