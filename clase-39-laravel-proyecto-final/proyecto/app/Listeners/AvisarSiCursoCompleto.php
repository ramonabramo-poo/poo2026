<?php

namespace App\Listeners;

use App\Enums\Rol;
use App\Events\AlumnoMatriculado;
use App\Models\User;
use App\Notifications\CursoCompleto;
use Illuminate\Support\Facades\Notification;

// Otro oyente del MISMO evento: cada uno hace una sola cosa
class AvisarSiCursoCompleto
{
    public function handle(AlumnoMatriculado $evento): void
    {
        $curso = $evento->curso;

        if ($curso->alumnos()->count() < $curso->plazas) {
            return;
        }

        $administradores = User::where('rol', Rol::Admin)->get();

        Notification::send($administradores, new CursoCompleto($curso));
    }
}
