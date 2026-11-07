<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CursoRequest;
use App\Http\Resources\AlumnoResource;
use App\Http\Resources\CursoResource;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CursoController extends Controller
{
    // GET /api/v1/cursos?buscar=php&categoria=diseno&por_pagina=5
    public function index(Request $request): AnonymousResourceCollection
    {
        $porPagina = min((int) $request->query('por_pagina', 10), 50);

        $cursos = Curso::publicados()
            ->with('categoria')
            ->withCount('alumnos')
            ->when($request->query('buscar'), fn (Builder $consulta, string $texto) => $consulta->buscar($texto))
            ->when($request->query('categoria'), function (Builder $consulta, string $slug) {
                $consulta->whereRelation('categoria', 'slug', $slug);
            })
            ->tap(fn (Builder $consulta) => $this->ordenar($consulta, $request->query('orden', 'titulo')))
            ->paginate($porPagina)
            ->withQueryString();

        // Con un paginador, la colección añade "links" y "meta" con los datos de la paginación
        return CursoResource::collection($cursos);
    }

    // Ejercicio 03: ?orden=precio (de menor a mayor) u ?orden=-precio (de mayor a menor)
    private function ordenar(Builder $consulta, string $orden): void
    {
        $permitidas = ['titulo', 'precio', 'horas', 'fecha_inicio'];
        $columna = ltrim($orden, '-');

        // Nunca metemos en la consulta una columna que no esté en la lista
        if (! in_array($columna, $permitidas, true)) {
            $columna = 'titulo';
        }

        $consulta->orderBy($columna, str_starts_with($orden, '-') ? 'desc' : 'asc');
    }

    // Ejercicio 02: GET /api/v1/cursos/{curso}/alumnos (con token y permiso para editar el curso)
    public function alumnos(Curso $curso): AnonymousResourceCollection
    {
        Gate::authorize('update', $curso);

        return AlumnoResource::collection($curso->alumnos()->orderBy('apellidos')->get());
    }

    // GET /api/v1/cursos/{curso}
    public function show(Curso $curso): CursoResource
    {
        return new CursoResource($curso->load('categoria')->loadCount('alumnos'));
    }

    // POST /api/v1/cursos (con token): el mismo CursoRequest que la web
    public function store(CursoRequest $request): CursoResource
    {
        $curso = Curso::create($request->validated());

        // Un recurso recién creado responde con 201 Created
        return new CursoResource($curso->load('categoria'));
    }

    // PUT /api/v1/cursos/{curso} (con token)
    public function update(CursoRequest $request, Curso $curso): CursoResource
    {
        $curso->update($request->validated());

        return new CursoResource($curso->load('categoria'));
    }

    // DELETE /api/v1/cursos/{curso} (con token): 204 No Content
    public function destroy(Curso $curso): Response
    {
        Gate::authorize('delete', $curso);

        $curso->delete();

        return response()->noContent();
    }
}
