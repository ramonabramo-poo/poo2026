<?php
declare(strict_types=1);

$notas = [7, 4, 9, 5, 8];
$roles = ["alumno", "editor"];
$usuario = ["nombre" => "Ana", "email" => "ana@mail.es"];

echo count($notas) . "<br>";               // 5
echo array_sum($notas) . "<br>";           // 33
echo max($notas) . " y " . min($notas) . "<br>";   // 9 y 4

// ¿Existe un VALOR?
var_dump(in_array("admin", $roles));       // bool(false)
echo "<br>";
// ¿Existe una CLAVE?
var_dump(array_key_exists("email", $usuario));   // bool(true)
echo "<br>";
// ¿En qué posición está?
var_dump(array_search(9, $notas));         // int(2)
echo "<br>";

// Unir dos arrays
$todos = array_merge(["pan", "leche"], ["huevos", "café"]);
echo implode(", ", $todos) . "<br>";       // pan, leche, huevos, café

// Sacar las claves o los valores
echo implode(", ", array_keys($usuario)) . "<br>";     // nombre, email
