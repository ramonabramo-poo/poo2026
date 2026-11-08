<?php
declare(strict_types=1);

function crearUsuario(string $nombre, string $apellido): string
{
    $inicial = mb_substr(trim($nombre), 0, 1);
    return mb_strtolower($inicial . trim($apellido));
}

echo crearUsuario("  Lucía", "Fernández ") . "<br>";   // lfernández
echo crearUsuario("Ramón", "Abramo");                  // rabramo
