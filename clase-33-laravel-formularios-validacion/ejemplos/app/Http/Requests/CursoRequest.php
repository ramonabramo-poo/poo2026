<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CursoRequest extends FormRequest
{
    // ¿Puede este usuario enviar el formulario? Lo decidiremos en la clase 34
    public function authorize(): bool
    {
        return true;
    }

    // Antes de validar: una casilla sin marcar no se envía, así que la convertimos en true/false
    protected function prepareForValidation(): void
    {
        $this->merge([
            'publicado' => $this->boolean('publicado'),
        ]);
    }

    public function rules(): array
    {
        return [
            'categoria_id' => ['required', 'exists:categorias,id'],
            'titulo' => [
                'required', 'string', 'min:3', 'max:120',
                // Único, salvo el propio curso cuando lo estamos editando
                Rule::unique('cursos', 'titulo')->ignore($this->route('curso')),
            ],
            'descripcion' => ['nullable', 'string', 'max:2000'],
            'imagen' => ['nullable', 'image', 'max:2048'],
            'horas' => ['required', 'integer', 'between:1,500'],
            'precio' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'plazas' => ['required', 'integer', 'between:1,100'],
            'fecha_inicio' => ['nullable', 'date', 'after_or_equal:today'],
            'publicado' => ['boolean'],
        ];
    }

    // Mensajes propios para algunas reglas (el resto sale de lang/es/validation.php)
    public function messages(): array
    {
        return [
            'titulo.unique' => 'Ya existe un curso con ese título.',
            'imagen.max' => 'La imagen no puede pesar más de 2 MB.',
            'fecha_inicio.after_or_equal' => 'El curso no puede empezar en el pasado.',
        ];
    }

    // Cómo se llama cada campo en los mensajes
    public function attributes(): array
    {
        return [
            'categoria_id' => 'categoría',
            'fecha_inicio' => 'fecha de inicio',
        ];
    }
}
