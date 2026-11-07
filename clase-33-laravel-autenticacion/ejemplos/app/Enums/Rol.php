<?php

namespace App\Enums;

// Los roles posibles de un usuario (un enum de PHP 8.1, como vimos en la clase 18)
enum Rol: string
{
    case Admin = 'admin';
    case Editor = 'editor';
    case Usuario = 'usuario';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Editor => 'Editor',
            self::Usuario => 'Usuario',
        };
    }
}
