<?php

// Ejercicio 05: un controlador que ha llegado a revisión. ¿Cuántos fallos encontráis?
// (No lo copiéis al proyecto: es para leerlo con ojo crítico)

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InformeController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $cursos = DB::select("SELECT * FROM cursos WHERE titulo LIKE '%$buscar%'");

        $filas = [];
        foreach (Curso::all() as $curso) {
            $filas[] = [
                'titulo' => $curso->titulo,
                'categoria' => $curso->categoria->nombre,
                'alumnos' => $curso->alumnos()->count(),
            ];
        }

        return view('informes.index', ['cursos' => $cursos, 'filas' => $filas]);
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::find($id);

        $curso->update($request->all());

        Log::info('Curso actualizado por ' . $request->user()->email . ' con la clave ' . $request->password);

        dd($curso);

        return redirect('/informes')->with('exito', 'Guardado');
    }

    public function exportar()
    {
        if (env('APP_ENV') == 'local') {
            $limite = 10;
        } else {
            $limite = 100000;
        }

        $todos = Curso::with('alumnos')->take($limite)->get();

        return response()->json($todos);
    }
}
