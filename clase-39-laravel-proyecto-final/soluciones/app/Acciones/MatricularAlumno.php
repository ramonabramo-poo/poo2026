<?php

namespace App\Acciones;

use App\Events\AlumnoMatriculado;
use App\Exceptions\SinPlazasException;
use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

// Ejercicio 04: una "acción" es una clase que hace UNA operación de negocio completa.
// La puede usar un controlador web, uno de la API, un comando o una prueba
class MatricularAlumno
{
    public function ejecutar(Curso $curso, Alumno $alumno): void
    {
        // Una transacción: o se hace todo, o nada
        DB::transaction(function () use ($curso, $alumno) {
            // lockForUpdate(): si dos personas matriculan a la vez en la última plaza,
            // la segunda espera a que termine la primera y ya no la encuentra libre
            $curso = Curso::lockForUpdate()->findOrFail($curso->id);

            if ($curso->alumnos()->whereKey($alumno->id)->exists()) {
                throw ValidationException::withMessages([
                    'alumno_id' => 'Ese alumno ya está matriculado en el curso.',
                ]);
            }

            if ($curso->alumnos()->count() >= $curso->plazas) {
                throw new SinPlazasException($curso);
            }

            $curso->alumnos()->attach($alumno);
        });

        AlumnoMatriculado::dispatch($alumno, $curso);
    }
}
