<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

// Devuelve los errores con el nombre del campo como clave
function validarRegistro(array $datos, string $clave, string $clave2, array $ciudades): array
{
    $errores = [];

    if (mb_strlen($datos["nombre"]) < 2) {
        $errores["nombre"] = "Escribe tu nombre.";
    }
    if (filter_var($datos["email"], FILTER_VALIDATE_EMAIL) === false) {
        $errores["email"] = "El email no es válido.";
    }
    $opcionesEdad = ["options" => ["min_range" => 16, "max_range" => 99]];
    if (filter_var($datos["edad"], FILTER_VALIDATE_INT, $opcionesEdad) === false) {
        $errores["edad"] = "La edad debe ser un número entre 16 y 99.";
    }
    if (!in_array($datos["ciudad"], $ciudades, true)) {
        $errores["ciudad"] = "Elige una ciudad de la lista.";
    }
    if (mb_strlen($clave) < 8) {
        $errores["clave"] = "La contraseña debe tener al menos 8 caracteres.";
    } elseif ($clave !== $clave2) {
        $errores["clave"] = "Las contraseñas no coinciden.";
    }

    return $errores;
}

$ciudades = ["Santander", "Torrelavega", "Laredo", "Castro Urdiales"];
$campos = ["nombre", "email", "edad", "ciudad"];
$errores = [];
$registrado = false;

$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$datos = [];
foreach ($campos as $campo) {
    $datos[$campo] = trim($_POST[$campo] ?? "");
}
$clave = $_POST["clave"] ?? "";
$clave2 = $_POST["clave2"] ?? "";

if ($esEnvio) {
    $errores = validarRegistro($datos, $clave, $clave2, $ciudades);
    $registrado = count($errores) === 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <style>
        body { font-family: sans-serif; max-width: 420px; margin: 2rem auto; }
        label { display: block; margin-top: .8rem; }
        input, select { width: 100%; padding: .3rem; }
        .error { color: #b00020; font-size: .9rem; }
    </style>
</head>
<body>
<h1>Registro</h1>

<?php if ($registrado): ?>
    <p>¡Bienvenido/a, <?= e($datos["nombre"]) ?>! Ya formas parte de la academia de <?= e($datos["ciudad"]) ?>.</p>
<?php else: ?>
    <form method="post">
        <label>Nombre <input name="nombre" value="<?= e($datos["nombre"]) ?>"></label>
        <span class="error"><?= e($errores["nombre"] ?? "") ?></span>

        <label>Email <input name="email" value="<?= e($datos["email"]) ?>"></label>
        <span class="error"><?= e($errores["email"] ?? "") ?></span>

        <label>Edad <input name="edad" value="<?= e($datos["edad"]) ?>"></label>
        <span class="error"><?= e($errores["edad"] ?? "") ?></span>

        <label>Ciudad
            <select name="ciudad">
                <option value="">-- Elige --</option>
                <?php foreach ($ciudades as $ciudad): ?>
                    <option <?= $ciudad === $datos["ciudad"] ? "selected" : "" ?>><?= e($ciudad) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <span class="error"><?= e($errores["ciudad"] ?? "") ?></span>

        <label>Contraseña <input type="password" name="clave"></label>
        <label>Repite la contraseña <input type="password" name="clave2"></label>
        <span class="error"><?= e($errores["clave"] ?? "") ?></span>

        <p><button type="submit">Registrarme</button></p>
    </form>
<?php endif; ?>
</body>
</html>
