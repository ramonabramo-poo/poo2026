<?php

namespace App\Jobs;

use App\Models\Alumno;
use App\Models\User;
use App\Notifications\ExportacionLista;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Throwable;

// Ejercicio 06: una tarea que puede tardar (miles de alumnos), así que va a la cola
class ExportarAlumnos implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    // Segundos de espera entre un intento y el siguiente
    public array $backoff = [10, 60];

    public function __construct(
        public User $usuario,
    ) {
    }

    public function handle(): void
    {
        $fichero = 'exportaciones/alumnos-' . now()->format('Ymd-His') . '.csv';

        // Lo escribimos primero en un fichero temporal, fila a fila
        $temporal = fopen('php://temp', 'r+');
        fputcsv($temporal, ['Nombre', 'Apellidos', 'Correo', 'Teléfono', 'Cursos'], ';');

        // cursor() trae los alumnos de uno en uno: no carga miles de objetos en memoria
        foreach (Alumno::withCount('cursos')->orderBy('apellidos')->cursor() as $alumno) {
            fputcsv($temporal, [$alumno->nombre, $alumno->apellidos, $alumno->email, $alumno->telefono, $alumno->cursos_count], ';');
        }

        rewind($temporal);
        Storage::put($fichero, stream_get_contents($temporal));   // disco privado
        fclose($temporal);

        $this->usuario->notify(new ExportacionLista(basename($fichero)));
    }

    // Si falla después de todos los intentos, avisamos también
    public function failed(?Throwable $error): void
    {
        $this->usuario->notify(new ExportacionLista(null));
    }
}
