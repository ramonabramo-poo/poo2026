<?php

// Ejercicio 06: un fichero de configuración propio. Se lee con config('academia.clave')
return [
    'telefono' => env('ACADEMIA_TELEFONO', '942 000 000'),
    'email' => env('ACADEMIA_EMAIL', 'info@academia-alpe.test'),
];
