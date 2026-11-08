<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    // Ejercicio 04: GET /categorias, con dos recuentos distintos de la misma relación
    public function index(): View
    {
        $categorias = Categoria::withCount([
            'cursos',
            'cursos as publicados_count' => fn (Builder $consulta) => $consulta->where('publicado', true),
        ])->orderBy('nombre')->get();

        return view('categorias.index', ['categorias' => $categorias]);
    }

    // Ejercicio 07: GET /categorias/{slug}/alumnos: alumnos con algún curso de esa categoría
    public function alumnos(Categoria $categoria): View
    {
        $alumnos = Alumno::whereHas('cursos', fn (Builder $curso) => $curso->where('categoria_id', $categoria->id))
            ->with(['cursos' => fn ($curso) => $curso->where('categoria_id', $categoria->id)])
            ->orderBy('apellidos')
            ->get();

        return view('categorias.alumnos', ['categoria' => $categoria, 'alumnos' => $alumnos]);
    }

    // GET /categorias/{categoria:slug}: busca la categoría por su slug
    public function show(Categoria $categoria): View
    {
        $cursos = $categoria->cursos()
            ->publicados()
            ->with('categoria')
            ->withCount('alumnos')
            ->orderBy('titulo')
            ->paginate(6);

        return view('categorias.show', [
            'categoria' => $categoria,
            'cursos' => $cursos,
        ]);
    }
}
