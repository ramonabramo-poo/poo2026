<?php
declare(strict_types=1);

function validarAlta(array $datos): array
{
    $errores = [];

    if (!filter_var($datos["email"] ?? "", FILTER_VALIDATE_EMAIL)) {
        $errores["email"] = "El correo no es válido";
    }
    // Exactamente 9 dígitos, empezando por 6, 7, 8 o 9
    if (!preg_match('/^[6-9][0-9]{8}$/', $datos["telefono"] ?? "")) {
        $errores["telefono"] = "El teléfono debe tener 9 cifras";
    }
    if (!preg_match('/^[0-9]{5}$/', $datos["cp"] ?? "")) {
        $errores["cp"] = "El código postal debe tener 5 cifras";
    }

    return $errores;
}

$pruebas = [
    ["email" => "ana@example.com", "telefono" => "612345678", "cp" => "39001"],
    ["email" => "ana@", "telefono" => "12345", "cp" => "3900A"],
];

foreach ($pruebas as $numero => $datos) {
    $errores = validarAlta($datos);
    echo "Prueba " . ($numero + 1) . ": ";
    echo count($errores) === 0 ? "todo correcto" : implode(" · ", $errores);
    echo "<br>";
}
