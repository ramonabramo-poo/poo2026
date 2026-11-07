<?php

namespace App\Exceptions;

use App\Models\Curso;
use Exception;
use Illuminate\Http\RedirectResponse;

// Una excepción propia que sabe cómo mostrarse (render) y cómo apuntarse en el log (context)
class SinPlazasException extends Exception
{
    public function __construct(
        public Curso $curso,
    ) {
        parent::__construct("No quedan plazas en el curso «{$curso->titulo}».");
    }

    // Datos extra que se guardan en el log junto al error
    public function context(): array
    {
        return ['curso_id' => $this->curso->id, 'plazas' => $this->curso->plazas];
    }

    // Lo que ve el usuario: vuelve atrás con el mensaje de error
    public function render(): RedirectResponse
    {
        return back()->with('error', $this->getMessage());
    }
}
