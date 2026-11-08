<?php
function probarAmbito()
{
    // Aquí dentro $mensaje NO existe: cada función tiene su propia "habitación"
    $mensaje = "Soy de dentro";
    return $mensaje;
}

// La forma correcta de usar un dato de fuera: pasarlo como parámetro
function saludar(string $nombre): string
{
    return "Hola, {$nombre}";
}

$mensaje = "Soy de fuera";
$usuario = "Pedro";

echo probarAmbito() . "<br>";   // Soy de dentro
echo $mensaje . "<br>";         // Soy de fuera (no se ha tocado)
echo saludar($usuario);
