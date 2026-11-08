<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\View\View;

class CategoriaController extends Controller
{
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
