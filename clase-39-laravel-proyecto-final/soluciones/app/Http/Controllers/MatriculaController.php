<?php

namespace App\Http\Controllers;

use App\Acciones\MatricularAlumno;
use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

// Ejercicio 04: el controlador solo recoge los datos, llama a la acción y responde
class MatriculaController extends Controller
{
    public function store(Request $request, Curso $curso, MatricularAlumno $matricular): RedirectResponse
    {
        $datos = $request->validate([
            'alumno_id' => ['required', 'exists:alumnos,id'],
        ], [
            'alumno_id.required' => 'Elige un alumno.',
        ]);

        $alumno = Alumno::findOrFail($datos['alumno_id']);

        // Si no quedan plazas o ya estaba, la acción lanza una excepción
        // y Laravel vuelve atrás con el mensaje
        $matricular->ejecutar($curso, $alumno);

        return back()->with('exito', "{$alumno->nombre_completo} matriculado en el curso.");
    }
}
