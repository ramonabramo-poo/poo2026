<?php

// Configuración propia de la academia: se lee con config('academia.clave')
return [
    'telefono' => '942 000 000',
    'email' => 'info@academia-alpe.test',
    'iva' => 0.21,
    'descuento_maximo' => 30,

    // Ejercicio 02: 'log' o 'archivo' (y 'ambos', ejercicio 08)
    'notificador' => env('ACADEMIA_NOTIFICADOR', 'log'),

    // Ejercicio 05
    'idiomas' => ['es' => 'Español', 'en' => 'English'],

    // Ejercicio 06: cuántas unidades de cada moneda vale un euro
    'cambios' => [
        'USD' => 1.08,
        'GBP' => 0.85,
        'CHF' => 0.95,
    ],
];
