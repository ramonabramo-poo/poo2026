<?php

namespace App\Listeners;

use App\Events\AlumnoMatriculado;
use App\Mail\MatriculaConfirmada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

// ShouldQueue: no se ejecuta durante la petición, sino después, en la cola
class EnviarConfirmacionMatricula implements ShouldQueue
{
    public function handle(AlumnoMatriculado $evento): void
    {
        Mail::to($evento->alumno->email)
            ->send(new MatriculaConfirmada($evento->alumno, $evento->curso));
    }
}
