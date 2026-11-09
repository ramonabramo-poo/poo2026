<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    // GET /login
    public function create(): View
    {
        return view('auth.login');
    }

    // POST /login
    public function store(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // attempt() busca el usuario por el email y comprueba la contraseña con password_verify()
        // Ejercicio 06: 'activo' => true añade una condición más a la búsqueda del usuario
        if (! Auth::attempt([...$credenciales, 'activo' => true], $request->boolean('recordarme'))) {
            return back()
                ->withErrors(['email' => 'El correo o la contraseña no son correctos, o la cuenta está desactivada.'])
                ->onlyInput('email');
        }

        // Nuevo identificador de sesión: evita la fijación de sesión (clase 12)
        $request->session()->regenerate();

        $usuario = Auth::user();

        // Ejercicio 07: ultimo_acceso no está en Fillable, así que lo asignamos directamente
        $usuario->ultimo_acceso = now();
        $usuario->save();

        // Ejercicio 10: cada rol empieza en una página distinta...
        $inicio = match (true) {
            $usuario->esAdmin() => route('admin.usuarios.index'),
            $usuario->esEditor() => route('mis-cursos'),
            default => route('inicio'),
        };

        // ...salvo que viniera de una página protegida: entonces, a esa
        return redirect()->intended($inicio)
            ->with('exito', "¡Hola, {$usuario->name}!");
    }

    // POST /logout
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio')->with('exito', 'Has cerrado la sesión.');
    }
}
