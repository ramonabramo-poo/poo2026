<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    // Ejercicio 01
    public function index(): View
    {
        return view('categorias.index', [
            'categorias' => Categoria::withCount('cursos')->orderBy('nombre')->get(),
        ]);
    }

    public function create(): View
    {
        return view('categorias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:60', 'unique:categorias,nombre'],
        ]);

        $categoria = Categoria::create([
            'nombre' => $datos['nombre'],
            'slug' => Str::slug($datos['nombre']),
        ]);

        return redirect()
            ->route('categorias.index')
            ->with('exito', "Categoría «{$categoria->nombre}» creada.");
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        if ($categoria->cursos()->withTrashed()->exists()) {
            return back()->with('error', 'No se puede borrar una categoría que tiene cursos.');
        }

        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('exito', "Categoría «{$categoria->nombre}» borrada.");
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
