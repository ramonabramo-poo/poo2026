<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

// Ejercicio 06: validación directamente en el controlador
class SugerenciaController extends Controller
{
    private const ASUNTOS = [
        'nuevo-curso' => 'Propuesta de un curso nuevo',
        'horario' => 'Horarios',
        'instalaciones' => 'Instalaciones',
        'otro' => 'Otro asunto',
    ];

    // Las sugerencias se guardan en storage/app/private/sugerencias.json (una por línea)
    private const FICHERO = 'sugerencias.json';

    public function create(): View
    {
        $sugerencias = [];

        if (Storage::exists(self::FICHERO)) {
            foreach (explode("\n", trim(Storage::get(self::FICHERO))) as $linea) {
                $sugerencias[] = json_decode($linea, true);
            }
        }

        return view('sugerencias.create', [
            'asuntos' => self::ASUNTOS,
            'sugerencias' => array_reverse($sugerencias),   // las más recientes primero
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email'],
            // in: solo admite las claves de nuestro array
            'asunto' => ['required', 'in:' . implode(',', array_keys(self::ASUNTOS))],
            'telefono' => ['nullable', 'regex:/^[0-9 ]{9,15}$/'],
            'texto' => ['required', 'string', 'min:20', 'max:1000'],
            // accepted: la casilla tiene que estar marcada
            'privacidad' => ['accepted'],
        ], [
            'asunto.in' => 'Elige un asunto de la lista.',
            'texto.min' => 'Cuéntanos un poco más: al menos :min caracteres.',
            'privacidad.accepted' => 'Tienes que aceptar la política de privacidad.',
        ]);

        unset($datos['privacidad']);
        $datos['fecha'] = now()->format('d/m/Y H:i');

        // append añade una línea al final del fichero (y lo crea si no existe)
        Storage::append(self::FICHERO, json_encode($datos, JSON_UNESCAPED_UNICODE));

        return redirect()
            ->route('sugerencias.create')
            ->with('exito', '¡Gracias por tu sugerencia!');
    }
}
