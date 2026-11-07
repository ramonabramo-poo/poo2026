<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Decide qué datos de un curso se publican en la API y con qué forma
class CursoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'slug' => $this->slug,
            'descripcion' => $this->descripcion,
            'horas' => $this->horas,
            'precio' => (float) $this->precio,
            'precio_con_iva' => $this->precio_con_iva,
            'plazas' => $this->plazas,
            'fecha_inicio' => $this->fecha_inicio?->toDateString(),
            'imagen' => $this->imagen ? asset('storage/' . $this->imagen) : null,
            // Solo si se cargó con with('categoria') / withCount('alumnos'): evita el N+1
            'categoria' => new CategoriaResource($this->whenLoaded('categoria')),
            'alumnos' => $this->whenCounted('alumnos'),
            // Solo los usuarios identificados ven si está publicado
            'publicado' => $this->when($request->user() !== null, $this->publicado),
            'enlace' => route('cursos.show', $this->resource),
        ];
    }
}
