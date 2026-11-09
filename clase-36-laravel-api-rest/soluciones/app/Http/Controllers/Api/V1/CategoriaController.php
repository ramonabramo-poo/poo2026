<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

// Ejercicios 01 y 10
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

    // Ejercicio 10: POST /api/v1/categorias   { "nombre": "Robótica" }
    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:60', 'unique:categorias,nombre'],
        ]);

        $categoria = Categoria::create([
            'nombre' => $datos['nombre'],
            'slug' => Str::slug($datos['nombre']),
        ]);

        // 201 Created y, en la cabecera Location, la dirección del nuevo recurso
        return (new CategoriaResource($categoria))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('api.v1.categorias.show', $categoria));
    }

    // Ejercicio 10: DELETE /api/v1/categorias/{categoria}: 409 si todavía tiene cursos
    public function destroy(Categoria $categoria): JsonResponse|Response
    {
        if ($categoria->cursos()->exists()) {
            return response()->json(['mensaje' => 'No se puede borrar una categoría que tiene cursos.'], 409);
        }

        $categoria->delete();

        return response()->noContent();
    }
}
