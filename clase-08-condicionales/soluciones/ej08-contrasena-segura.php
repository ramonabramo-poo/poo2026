<?php
$password = "secreta2026";

$longitudOk = strlen($password) >= 8;
// Si al pasarla a minúsculas cambia, es que tenía alguna mayúscula
$tieneMayuscula = strtolower($password) !== $password;
$tieneNumero = str_contains($password, "0") || str_contains($password, "1") || str_contains($password, "2")
    || str_contains($password, "3") || str_contains($password, "4") || str_contains($password, "5")
    || str_contains($password, "6") || str_contains($password, "7") || str_contains($password, "8")
    || str_contains($password, "9");
// (en la clase 11 veremos formas mucho más cortas de comprobar esto)

if (!$longitudOk) {
    $mensaje = "Demasiado corta: mínimo 8 caracteres";
} elseif (!$tieneMayuscula) {
    $mensaje = "Le falta al menos una mayúscula";
} elseif (!$tieneNumero) {
    $mensaje = "Le falta al menos un número";
} else {
    $mensaje = "Contraseña segura ✅";
}

echo "«{$password}»: $mensaje";
