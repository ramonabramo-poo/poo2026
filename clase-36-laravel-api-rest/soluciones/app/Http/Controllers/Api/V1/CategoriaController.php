<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

// Ejercicio 01
class CategoriaController extends Controller
{
    // GET /api/v1/categorias
    public function index(): AnonymousResourceCollection
    {
        return CategoriaResource::collection(
            Categoria::withCount('cursos')->orderBy('nombre')->get()
        );
    }

    // GET /api/v1/categorias/{categoria}: con sus cursos publicados
    public function show(Categoria $categoria): CategoriaResource
    {
        $categoria->load(['cursos' => fn ($consulta) => $consulta->publicados()->with('categoria')->orderBy('titulo')]);

        return new CategoriaResource($categoria->loadCount('cursos'));
    }
}
