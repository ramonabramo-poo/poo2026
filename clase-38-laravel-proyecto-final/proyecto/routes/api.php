<?php

use App\Http\Controllers\Api\V1\CursoController;
use App\Http\Controllers\Api\V1\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Todas estas rutas empiezan por /api y devuelven JSON

Route::get('/estado', function () {
    return [
        'aplicacion' => config('app.name'),
        'estado' => 'ok',
        'hora' => now()->toIso8601String(),
    ];
});

// Versión 1 de la API: /api/v1/...
Route::prefix('v1')->name('api.v1.')->middleware('throttle:60,1')->group(function () {
    // Públicas
    Route::post('/tokens', [TokenController::class, 'store'])->middleware('throttle:5,1')->name('tokens.store');
    Route::apiResource('cursos', CursoController::class)->only(['index', 'show']);

    // Con token: cabecera  Authorization: Bearer 1|abc...
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/yo', fn (Request $request) => $request->user()->only('id', 'name', 'email', 'rol'))->name('yo');
        Route::delete('/tokens/actual', [TokenController::class, 'destroy'])->name('tokens.destroy');
        Route::apiResource('cursos', CursoController::class)->except(['index', 'show']);
    });
});
