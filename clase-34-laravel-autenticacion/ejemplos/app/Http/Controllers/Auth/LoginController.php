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
        if (! Auth::attempt($credenciales, $request->boolean('recordarme'))) {
            return back()
                ->withErrors(['email' => 'El correo o la contraseña no son correctos.'])
                ->onlyInput('email');
        }

        // Nuevo identificador de sesión: evita la fijación de sesión (clase 13)
        $request->session()->regenerate();

        // A la página que quería ver antes de que le pidiéramos identificarse, o a la portada
        return redirect()->intended(route('inicio'))
            ->with('exito', '¡Hola, ' . Auth::user()->name . '!');
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
