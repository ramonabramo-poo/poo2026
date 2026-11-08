<?php
declare(strict_types=1);

// Nuestros usuarios. Más adelante vendrán de la base de datos.
// Las contraseñas NUNCA se guardan tal cual: guardamos su hash.
// (Las dos son "secreto123". Generad otras con 03-generar-hash.php)
return [
    "ana" => [
        "nombre" => "Ana García",
        "rol" => "admin",
        "hash" => '$2y$10$L7JgWw0q6b6yLkPrbL54iuxC7tDJyjSOGROC8ru6iMMBZxFaSI7Xu',
    ],
    "luis" => [
        "nombre" => "Luis Pérez",
        "rol" => "alumno",
        "hash" => '$2y$10$lQwUqTR9sboM1jeOiS51PuCXLdwUNF9oGItLkT4TVYgFXqhWjpRFW',
    ],
];
