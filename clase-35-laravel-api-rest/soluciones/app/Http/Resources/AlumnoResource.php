<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Ejercicio 02
class AlumnoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre_completo,
            'email' => $this->email,
            // Solo cuando el alumno viene de la relación con el curso (tabla alumno_curso)
            'matricula' => $this->whenPivotLoaded('alumno_curso', fn () => [
                'fecha' => $this->pivot->created_at->toDateString(),
                'nota' => $this->pivot->nota !== null ? (float) $this->pivot->nota : null,
            ]),
        ];
    }
}
