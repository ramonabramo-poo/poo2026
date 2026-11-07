<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Rol;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

// Ejercicio 03: solo el administrador (gate 'administrar-usuarios' en las rutas)
class UsuarioController extends Controller
{
    public function index(): View
    {
        return view('admin.usuarios', [
            'usuarios' => User::orderBy('name')->get(),
            'roles' => Rol::cases(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $datos = $request->validate([
            'rol' => ['required', Rule::enum(Rol::class)],
        ]);

        if ($user->is($request->user())) {
            return back()->with('error', 'No puedes cambiar tu propio rol.');
        }

        // rol no está en Fillable (¡a propósito!), así que lo asignamos directamente
        $user->rol = Rol::from($datos['rol']);
        $user->save();

        return back()->with('exito', "{$user->name} ahora es {$user->rol->etiqueta()}.");
    }
}
