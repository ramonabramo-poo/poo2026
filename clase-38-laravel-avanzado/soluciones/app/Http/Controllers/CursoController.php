<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
use App\Models\Alumno;
use App\Models\Categoria;
use App\Models\Curso;
use App\Servicios\CalculadoraPrecios;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        $curso->load(['categoria', 'alumnos' => fn ($consulta) => $consulta->orderBy('apellidos')]);

        // Para el desplegable de matricular: los alumnos que todavía no están en el curso
        $alumnosLibres = Alumno::whereNotIn('id', $curso->alumnos->pluck('id'))
            ->orderBy('apellidos')
            ->get()
            ->pluck('nombre_completo', 'id');

        // Ejercicio 07: un contador en la caché. add() solo guarda si la clave NO existe,
        // así nos aseguramos de que hay un 0 antes de sumar uno
        $clave = "visitas.curso.{$curso->id}";
        Cache::add($clave, 0);
        $visitas = Cache::increment($clave);

        return view('cursos.show', [
            'curso' => $curso,
            'alumnosLibres' => $alumnosLibres,
            'visitas' => $visitas,
        ]);
    }

    // GET /cursos/{curso}/presupuesto?descuento=10
    // El contenedor crea la calculadora (con su IVA) y nos la pasa: inyección de dependencias
    public function presupuesto(Request $request, Curso $curso, CalculadoraPrecios $calculadora): View
    {
        $descuento = (int) $request->query('descuento', 0);
        $conDescuento = $calculadora->conDescuento((float) $curso->precio, $descuento);

        return view('cursos.presupuesto', [
            'curso' => $curso,
            'descuento' => $descuento,
            'calculadora' => $calculadora,
            'base' => $conDescuento,
            'total' => $calculadora->conIva($conDescuento),
        ]);
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

        $curso = Curso::create($datos);

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
