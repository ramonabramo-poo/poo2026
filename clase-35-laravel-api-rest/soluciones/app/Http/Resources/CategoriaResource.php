<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'slug' => $this->slug,
            // Ejercicio 01
            'total_cursos' => $this->whenCounted('cursos'),
            'cursos' => CursoResource::collection($this->whenLoaded('cursos')),
        ];
    }
}
