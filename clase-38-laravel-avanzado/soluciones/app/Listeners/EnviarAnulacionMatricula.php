<?php

namespace App\Listeners;

use App\Events\AlumnoDesmatriculado;
use App\Mail\MatriculaAnulada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

// Ejercicio 05: como la confirmación, va a la cola
class EnviarAnulacionMatricula implements ShouldQueue
{
    public function handle(AlumnoDesmatriculado $evento): void
    {
        Mail::to($evento->alumno->email)
            ->send(new MatriculaAnulada($evento->alumno, $evento->curso));
    }
}
