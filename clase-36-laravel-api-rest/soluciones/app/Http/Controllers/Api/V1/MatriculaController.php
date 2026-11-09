<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlumnoResource;
use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

// Ejercicios 05 y 06: las matrículas de un curso, como un recurso "hijo" del curso
class MatriculaController extends Controller
{
    // POST /api/v1/cursos/{curso}/alumnos   { "alumno_id": 7 }
    public function store(Request $request, Curso $curso): JsonResponse
    {
        Gate::authorize('update', $curso);

        $datos = $request->validate([
            'alumno_id' => [
                'required', 'integer', 'exists:alumnos,id',
                Rule::unique('alumno_curso')->where('curso_id', $curso->id),
            ],
        ], [
            'alumno_id.unique' => 'Ese alumno ya está matriculado en el curso.',
        ]);

        // 409 Conflict: la petición es correcta, pero choca con el estado del recurso
        if ($curso->alumnos()->count() >= $curso->plazas) {
            return response()->json(['mensaje' => 'No quedan plazas libres en este curso.'], 409);
        }

        $curso->alumnos()->attach($datos['alumno_id']);

        // Lo leemos a través de la relación para que traiga los datos de la matrícula (pivot)
        $alumno = $curso->alumnos()->find($datos['alumno_id']);

        return (new AlumnoResource($alumno))->response()->setStatusCode(201);
    }

    // PATCH /api/v1/cursos/{curso}/alumnos/{alumno}   { "nota": 8.5 }
    public function update(Request $request, Curso $curso, Alumno $alumno): AlumnoResource
    {
        Gate::authorize('update', $curso);

        $matriculado = $curso->alumnos()->find($alumno->id);
        abort_if($matriculado === null, 404);

        $datos = $request->validate([
            'nota' => ['present', 'nullable', 'numeric', 'between:0,10'],
        ]);

        $curso->alumnos()->updateExistingPivot($alumno->id, ['nota' => $datos['nota']]);

        return new AlumnoResource($curso->alumnos()->find($alumno->id));
    }

    // DELETE /api/v1/cursos/{curso}/alumnos/{alumno}: 204, o 404 si no estaba matriculado
    public function destroy(Curso $curso, Alumno $alumno): Response
    {
        Gate::authorize('update', $curso);

        // detach() devuelve cuántas filas ha borrado de alumno_curso
        abort_if($curso->alumnos()->detach($alumno->id) === 0, 404);

        return response()->noContent();
    }
}
