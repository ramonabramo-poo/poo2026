<?php

namespace App\Listeners;

use App\Notifications\Bienvenida;
use Illuminate\Auth\Events\Registered;

// Ejercicio 09: escuchamos un evento que NO es nuestro, sino de Laravel
class EnviarBienvenida
{
    public function handle(Registered $evento): void
    {
        $evento->user->notify(new Bienvenida());
    }
}
