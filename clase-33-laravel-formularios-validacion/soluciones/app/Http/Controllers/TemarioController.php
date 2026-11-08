<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

// Ejercicio 07: el temario se guarda en el disco privado (storage/app/private),
// así que no se puede abrir con una URL directa: solo a través de esta ruta
class TemarioController extends Controller
{
    public static function ruta(Curso $curso): string
    {
        return "temarios/curso-{$curso->id}.pdf";
    }

    // POST /cursos/{curso}/temario
    public function store(Request $request, Curso $curso): RedirectResponse
    {
        $request->validate([
            'temario' => ['required', 'file', 'mimes:pdf', 'max:5120'],   // 5 MB
        ], [
            'temario.required' => 'Elige un fichero PDF.',
            'temario.mimes' => 'El temario tiene que ser un PDF.',
            'temario.max' => 'El temario no puede pesar más de 5 MB.',
        ]);

        // storeAs: guardamos con un nombre fijo, así el nuevo sustituye al anterior
        $request->file('temario')->storeAs('temarios', "curso-{$curso->id}.pdf");

        return back()->with('exito', 'Temario subido.');
    }

    // GET /cursos/{curso}/temario
    public function show(Curso $curso): StreamedResponse
    {
        abort_unless(Storage::exists(self::ruta($curso)), 404);

        // El navegador lo descarga con un nombre bonito
        return Storage::download(self::ruta($curso), "temario-{$curso->slug}.pdf");
    }
}
