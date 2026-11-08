<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// Ejercicio 02
class MatriculaController extends Controller
{
    public function store(Request $request, Curso $curso): RedirectResponse
    {
        $datos = $request->validate([
            'alumno_id' => [
                'required',
                'exists:alumnos,id',
                // No puede estar ya matriculado en ESTE curso
                Rule::unique('alumno_curso')->where('curso_id', $curso->id),
            ],
        ], [
            'alumno_id.required' => 'Elige un alumno.',
            'alumno_id.unique' => 'Ese alumno ya está matriculado en el curso.',
        ]);

        if ($curso->alumnos()->count() >= $curso->plazas) {
            return back()->with('error', 'No quedan plazas libres en este curso.');
        }

        $curso->alumnos()->attach($datos['alumno_id']);

        return back()->with('exito', 'Alumno matriculado.');
    }

    // Ejercicio 09: matricular a varios alumnos de una vez (casillas alumnos[])
    public function storeVarios(Request $request, Curso $curso): RedirectResponse
    {
        $datos = $request->validate([
            'alumnos' => ['required', 'array', 'min:1'],
            // alumnos.* valida CADA elemento del array
            'alumnos.*' => [
                'integer',
                'exists:alumnos,id',
                Rule::unique('alumno_curso', 'alumno_id')->where('curso_id', $curso->id),
            ],
        ], [
            'alumnos.required' => 'Marca al menos un alumno.',
            'alumnos.*.unique' => 'Alguno de los alumnos ya estaba matriculado.',
        ]);

        $libres = $curso->plazas - $curso->alumnos()->count();

        if (count($datos['alumnos']) > $libres) {
            return back()->with('error', "Solo quedan {$libres} plazas libres.");
        }

        $curso->alumnos()->attach($datos['alumnos']);

        return back()->with('exito', 'Alumnos matriculados: ' . count($datos['alumnos']) . '.');
    }
}
