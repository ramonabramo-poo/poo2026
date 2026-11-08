<?php
declare(strict_types=1);

// Indexado: los cajones se numeran solos, empezando por el 0
$frutas = ["manzana", "pera", "plátano"];
echo $frutas[0] . "<br>";   // manzana

// Asociativo: cada cajón tiene una etiqueta con nombre
$alumno = ["nombre" => "Carlos", "nota" => 8.5];
echo $alumno["nombre"] . "<br>";   // Carlos

// Añadir
$frutas[] = "kiwi";                    // al final de la lista
$alumno["email"] = "carlos@mail.es";   // nueva etiqueta

// Modificar
$frutas[1] = "melocotón";
$alumno["nota"] = 9;

// Eliminar
unset($alumno["email"]);

echo "<pre>";
print_r($frutas);
print_r($alumno);
echo "</pre>";

// Leer una clave que no existe da un Warning... salvo que uséis ??
echo $alumno["telefono"] ?? "Sin teléfono";
