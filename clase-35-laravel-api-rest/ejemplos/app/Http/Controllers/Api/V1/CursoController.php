<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CursoRequest;
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
            ->orderBy('titulo')
            ->paginate($porPagina)
            ->withQueryString();

        // Con un paginador, la colección añade "links" y "meta" con los datos de la paginación
        return CursoResource::collection($cursos);
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
