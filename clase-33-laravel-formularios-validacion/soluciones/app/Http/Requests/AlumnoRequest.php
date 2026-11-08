<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// Ejercicios 04 y 05: el mismo Form Request sirve para dar de alta y para editar
class AlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:60'],
            'apellidos' => ['required', 'string', 'max:100'],
            'email' => [
                'required', 'email', 'max:255',
                // Al editar, el propio alumno no cuenta como "repetido"
                // (al crear, $this->route('alumno') es null y no ignora a nadie)
                Rule::unique('alumnos', 'email')->ignore($this->route('alumno')),
            ],
            'telefono' => ['nullable', 'regex:/^[0-9 ]{9,15}$/'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Ya hay un alumno con ese correo.',
            'telefono.regex' => 'El teléfono debe tener entre 9 y 15 cifras (se admiten espacios).',
            'fecha_nacimiento.before' => 'La fecha de nacimiento tiene que ser anterior a hoy.',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'correo',
            'telefono' => 'teléfono',
            'fecha_nacimiento' => 'fecha de nacimiento',
        ];
    }
}
