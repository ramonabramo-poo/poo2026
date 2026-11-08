<?php
declare(strict_types=1);

// Emails: no inventéis nada, PHP ya trae un validador
$emails = ["ana@mail.es", "esto-no-es-un-email", "luis@empresa.com"];

foreach ($emails as $email) {
    $valido = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    echo $email . ": " . ($valido ? "válido" : "NO válido") . "<br>";
}

echo "<hr>";

// Para saber más: una expresión regular sencilla.
// Teléfono español: empieza por 6, 7, 8 o 9 y le siguen 8 cifras
$telefonos = ["612345678", "512345678", "61234"];
foreach ($telefonos as $tel) {
    $valido = preg_match('/^[6-9][0-9]{8}$/', $tel) === 1;
    echo $tel . ": " . ($valido ? "válido" : "NO válido") . "<br>";
}
