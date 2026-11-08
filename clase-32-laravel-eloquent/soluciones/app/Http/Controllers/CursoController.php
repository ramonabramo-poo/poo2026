<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CursoController extends Controller
{
    // GET /cursos  y  GET /cursos?buscar=php&page=2
    public function index(Request $request): View
    {
        $buscar = $request->query('buscar', '');
        $maximo = $request->query('max', '');  // Ejercicio 02
        $categoria = $request->query('categoria', '');  // Ejercicio 06

        $cursos = Curso::publicados()
            ->with('categoria')          // carga ansiosa: evita el problema N+1
            ->withCount('alumnos')       // añade $curso->alumnos_count
            ->when($buscar !== '', fn (Builder $consulta) => $consulta->buscar($buscar))
            ->when(is_numeric($maximo), fn (Builder $consulta) => $consulta->precioMaximo((float) $maximo))
            ->when($categoria !== '', fn (Builder $consulta) => $consulta->deCategoria($categoria))
            ->orderBy('titulo')
            ->paginate(6)
            ->withQueryString();         // los enlaces de página conservan ?buscar=

        return view('cursos.index', [
            'cursos' => $cursos,
            'buscar' => $buscar,
            'maximo' => $maximo,
        ]);
    }

    // GET /cursos/{curso}: route model binding, o 404 si no existe
    public function show(Curso $curso): View
    {
        $curso->load(['categoria', 'alumnos' => fn ($consulta) => $consulta->orderBy('apellidos')]);

        return view('cursos.show', ['curso' => $curso]);
    }
}
