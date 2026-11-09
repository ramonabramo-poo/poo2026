<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TokenController extends Controller
{
    // POST /api/v1/tokens: correo + contraseña → un token
    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'dispositivo' => ['required', 'string', 'max:60'],
        ]);

        $usuario = User::where('email', $datos['email'])->first();

        if ($usuario === null || ! Hash::check($datos['password'], $usuario->password)) {
            throw ValidationException::withMessages([
                'email' => 'El correo o la contraseña no son correctos.',
            ]);
        }

        // Crea el token, lo guarda cifrado en personal_access_tokens y nos da el texto UNA sola vez
        // Ejercicio 09: lo que puede hacer el token depende del rol
        $habilidades = $usuario->esAdmin() || $usuario->esEditor()
            ? ['cursos:leer', 'cursos:escribir']
            : ['cursos:leer'];

        $token = $usuario->createToken($datos['dispositivo'], $habilidades);

        return response()->json([
            'token' => $token->plainTextToken,
            'tipo' => 'Bearer',
            'habilidades' => $habilidades,
            'usuario' => $usuario->only('id', 'name', 'email'),
        ], 201);
    }

    // Ejercicio 08: GET /api/v1/tokens, los tokens del usuario (sin el texto secreto, claro)
    public function index(Request $request): JsonResponse
    {
        $actual = $request->user()->currentAccessToken()->id;

        $tokens = $request->user()->tokens()->latest()->get()->map(fn ($token) => [
            'id' => $token->id,
            'dispositivo' => $token->name,
            'habilidades' => $token->abilities,
            'creado' => $token->created_at->toIso8601String(),
            'ultimo_uso' => $token->last_used_at?->toIso8601String(),
            'actual' => $token->id === $actual,
        ]);

        return response()->json(['data' => $tokens]);
    }

    // Ejercicio 08: DELETE /api/v1/tokens/{id}, anula uno de SUS tokens (por ejemplo, el del móvil perdido)
    public function destroyUno(Request $request, int $id): Response
    {
        // Buscando a través de la relación, el token de otro usuario da 404
        $request->user()->tokens()->findOrFail($id)->delete();

        return response()->noContent();
    }

    // DELETE /api/v1/tokens/actual: anula el token con el que se hace la petición
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['mensaje' => 'Token anulado.']);
    }
}
