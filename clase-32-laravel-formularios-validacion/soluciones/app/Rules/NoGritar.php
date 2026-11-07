<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

// Ejercicio 03: no se admiten textos escritos enteros en mayúsculas
class NoGritar implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $soloLetras = preg_replace('/[^\p{L}]/u', '', (string) $value);

        if (mb_strlen($soloLetras) > 3 && mb_strtoupper($soloLetras) === $soloLetras) {
            $fail('El campo :attribute no puede estar escrito todo en mayúsculas.');
        }
    }
}
