<?php

namespace App\Jobs;

use App\Models\Curso;
use App\Notifications\RecordatorioInicioCurso;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

// Un job: una tarea que se guarda en la cola y la ejecuta el "worker" cuando puede
class EnviarRecordatoriosCurso implements ShouldQueue
{
    use Queueable;

    // Si falla, se reintenta hasta 3 veces
    public int $tries = 3;

    public function __construct(
        public Curso $curso,
    ) {}

    public function handle(): void
    {
        Notification::send($this->curso->alumnos, new RecordatorioInicioCurso($this->curso));

        Log::channel('academia')->info("Recordatorios enviados: {$this->curso->titulo}", [
            'alumnos' => $this->curso->alumnos->count(),
        ]);
    }
}
