<?php

namespace App\Listeners;

use App\Events\AlumnoDesmatriculado;
use App\Events\AlumnoMatriculado;
use Illuminate\Support\Facades\Log;

// Ejercicio 08: un oyente que escucha DOS eventos. Laravel lo descubre solo:
// cada método que empieza por "handle" escucha el evento que recibe como parámetro
class RegistrarMatriculasEnLog
{
    public function handleMatriculado(AlumnoMatriculado $evento): void
    {
        Log::channel('matriculas')->info('Alta', $this->datos($evento->alumno, $evento->curso));
    }

    public function handleDesmatriculado(AlumnoDesmatriculado $evento): void
    {
        Log::channel('matriculas')->warning('Baja', $this->datos($evento->alumno, $evento->curso));
    }

    private function datos($alumno, $curso): array
    {
        return [
            'alumno' => $alumno->nombre_completo,
            'curso' => $curso->titulo,
            'usuario' => auth()->user()?->email ?? 'sistema',
        ];
    }
}
