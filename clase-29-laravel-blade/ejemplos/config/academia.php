<?php

// Datos provisionales de la academia: en la clase 30 se irán a la base de datos
return [
    'telefono' => '942 000 000',
    'email' => 'info@academia-alpe.test',

    'categorias' => [
        'programacion' => 'Programación',
        'diseno' => 'Diseño',
        'ofimatica' => 'Ofimática',
    ],

    'cursos' => [
        1 => ['id' => 1, 'titulo' => 'PHP desde cero', 'categoria' => 'programacion', 'horas' => 60, 'precio' => 250.0],
        2 => ['id' => 2, 'titulo' => 'JavaScript moderno', 'categoria' => 'programacion', 'horas' => 50, 'precio' => 220.0],
        3 => ['id' => 3, 'titulo' => 'Laravel profesional', 'categoria' => 'programacion', 'horas' => 80, 'precio' => 390.0],
        4 => ['id' => 4, 'titulo' => 'Diseño web con Figma', 'categoria' => 'diseno', 'horas' => 30, 'precio' => 180.0],
        5 => ['id' => 5, 'titulo' => 'Excel avanzado', 'categoria' => 'ofimatica', 'horas' => 25, 'precio' => 120.0],
    ],
];
