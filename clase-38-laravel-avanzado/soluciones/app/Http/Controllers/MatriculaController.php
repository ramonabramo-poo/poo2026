<?php

namespace App\Http\Controllers;

use App\Events\AlumnoDesmatriculado;
use App\Events\AlumnoMatriculado;
use App\Exceptions\SinPlazasException;
use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// La solución del ejercicio 02 de la clase 33, ahora con un evento
class MatriculaController extends Controller
{
    public function store(Request $request, Curso $curso): RedirectResponse
    {
        $datos = $request->validate([
            'alumno_id' => [
                'required',
                'exists:alumnos,id',
                Rule::unique('alumno_curso')->where('curso_id', $curso->id),
            ],
        ], [
            'alumno_id.required' => 'Elige un alumno.',
            'alumno_id.unique' => 'Ese alumno ya está matriculado en el curso.',
        ]);

        if ($curso->alumnos()->count() >= $curso->plazas) {
            throw new SinPlazasException($curso);
        }

        $alumno = Alumno::findOrFail($datos['alumno_id']);
        $curso->alumnos()->attach($alumno);

        // Avisamos de que ha pasado algo. Quién reacciona y cómo ya no es cosa del controlador
        AlumnoMatriculado::dispatch($alumno, $curso);

        return back()->with('exito', "{$alumno->nombre_completo} matriculado en el curso.");
    }

    // Ejercicio 05: DELETE /cursos/{curso}/matriculas/{alumno}
    public function destroy(Curso $curso, Alumno $alumno): RedirectResponse
    {
        // detach() devuelve cuántas filas ha borrado: 0 si no estaba matriculado
        abort_if($curso->alumnos()->detach($alumno) === 0, 404);

        AlumnoDesmatriculado::dispatch($alumno, $curso);

        return back()->with('exito', "{$alumno->nombre_completo} ya no está matriculado en el curso.");
    }
}
