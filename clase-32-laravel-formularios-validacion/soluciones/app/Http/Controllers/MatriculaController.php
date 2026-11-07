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
}
