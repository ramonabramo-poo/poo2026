<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

// Ejercicios 01 y 02: cada usuario gestiona SU perfil, así que no hay {id} en la ruta
class PerfilController extends Controller
{
    public function edit(Request $request): View
    {
        return view('perfil.edit', [
            'usuario' => $request->user(),
            'perfil' => $request->user()->perfil,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'ciudad' => ['nullable', 'string', 'max:80'],
            'biografia' => ['nullable', 'string', 'max:1000'],
        ]);

        $usuario = $request->user();
        $usuario->update(['name' => $datos['name']]);

        // Si todavía no tiene perfil, lo crea; si lo tiene, lo actualiza
        $usuario->perfil()->updateOrCreate([], [
            'ciudad' => $datos['ciudad'] ?? null,
            'biografia' => $datos['biografia'] ?? null,
        ]);

        return back()->with('exito', 'Perfil actualizado.');
    }

    public function cambiarPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password_actual' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'password_actual.current_password' => 'La contraseña actual no es correcta.',
        ]);

        $request->user()->update(['password' => $request->input('password')]);

        return back()->with('exito', 'Contraseña cambiada.');
    }
}
