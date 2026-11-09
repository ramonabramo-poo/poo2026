<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
use App\Models\Categoria;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CursoController extends Controller
{
    // GET /cursos  y  GET /cursos?buscar=php&page=2
    public function index(Request $request): View
    {
        $buscar = $request->query('buscar', '');

        $cursos = Curso::publicados()
            ->with('categoria')          // carga ansiosa: evita el problema N+1
            ->withCount('alumnos')       // añade $curso->alumnos_count
            ->when($buscar !== '', fn (Builder $consulta) => $consulta->buscar($buscar))
            ->orderBy('titulo')
            ->paginate(6)
            ->withQueryString();         // los enlaces de página conservan ?buscar=

        return view('cursos.index', [
            'cursos' => $cursos,
            'buscar' => $buscar,
        ]);
    }

    // GET /cursos/{curso}: route model binding, o 404 si no existe
    public function show(Curso $curso): View
    {
        Gate::authorize('view', $curso);  // Ejercicio 08

        $curso->load(['categoria', 'alumnos' => fn ($consulta) => $consulta->orderBy('apellidos')]);

        return view('cursos.show', ['curso' => $curso]);
    }

    // Ejercicio 05: GET /mis-cursos, los cursos del usuario, publicados o no
    public function misCursos(Request $request): View
    {
        $cursos = $request->user()->cursos()
            ->with('categoria')
            ->withCount('alumnos')
            ->orderBy('titulo')
            ->get();

        return view('cursos.mis-cursos', ['cursos' => $cursos]);
    }

    // GET /cursos/create
    public function create(): View
    {
        Gate::authorize('create', Curso::class);  // si no puede, error 403

        return view('cursos.create', [
            'curso' => new Curso(['plazas' => 20, 'publicado' => true]),
            'categorias' => Categoria::orderBy('nombre')->pluck('nombre', 'id'),
        ]);
    }

    // POST /cursos: si la validación falla, Laravel vuelve al formulario solo
    public function store(CursoRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        if ($request->hasFile('imagen')) {
            // Guarda en storage/app/public/cursos con un nombre único y devuelve la ruta
            $datos['imagen'] = $request->file('imagen')->store('cursos', 'public');
        }

        // Ejercicio 04: create() a través de la relación rellena user_id solo
        $curso = $request->user()->cursos()->create($datos);

        return redirect()
            ->route('cursos.show', $curso)
            ->with('exito', "Curso «{$curso->titulo}» creado.");
    }

    // GET /cursos/{curso}/edit
    public function edit(Curso $curso): View
    {
        Gate::authorize('update', $curso);

        return view('cursos.edit', [
            'curso' => $curso,
            'categorias' => Categoria::orderBy('nombre')->pluck('nombre', 'id'),
        ]);
    }

    // PUT /cursos/{curso}
    public function update(CursoRequest $request, Curso $curso): RedirectResponse
    {
        $datos = $request->validated();

        if ($request->hasFile('imagen')) {
            if ($curso->imagen !== null) {
                Storage::disk('public')->delete($curso->imagen);
            }

            $datos['imagen'] = $request->file('imagen')->store('cursos', 'public');
        }

        $curso->update($datos);

        return redirect()
            ->route('cursos.show', $curso)
            ->with('exito', 'Cambios guardados.');
    }

    // DELETE /cursos/{curso}: borrado lógico (la imagen se conserva por si se restaura)
    public function destroy(Curso $curso): RedirectResponse
    {
        Gate::authorize('delete', $curso);

        $curso->delete();

        return redirect()
            ->route('cursos.index')
            ->with('exito', "Curso «{$curso->titulo}» borrado.");
    }
}
