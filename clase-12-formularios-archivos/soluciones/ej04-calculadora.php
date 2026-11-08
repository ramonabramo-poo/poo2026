<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

$operaciones = ["sumar" => "+", "restar" => "−", "multiplicar" => "×", "dividir" => "÷"];
$resultado = null;
$error = "";

$a = trim($_POST["a"] ?? "");
$b = trim($_POST["b"] ?? "");
$operacion = $_POST["operacion"] ?? "sumar";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!is_numeric($a) || !is_numeric($b)) {
        $error = "Escribe dos números";
    } elseif (!array_key_exists($operacion, $operaciones)) {
        $error = "Operación no válida";
    } elseif ($operacion === "dividir" && (float) $b === 0.0) {
        $error = "No se puede dividir entre cero";
    } else {
        $resultado = match ($operacion) {
            "sumar" => (float) $a + (float) $b,
            "restar" => (float) $a - (float) $b,
            "multiplicar" => (float) $a * (float) $b,
            "dividir" => (float) $a / (float) $b,
        };
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Calculadora</title></head>
<body>
    <h1>Calculadora</h1>
    <form method="post">
        <input name="a" value="<?= e($a) ?>" size="6">
        <select name="operacion">
            <?php foreach ($operaciones as $clave => $simbolo): ?>
                <option value="<?= $clave ?>" <?= $clave === $operacion ? "selected" : "" ?>><?= $simbolo ?></option>
            <?php endforeach; ?>
        </select>
        <input name="b" value="<?= e($b) ?>" size="6">
        <button>=</button>
    </form>
    <?php if ($error !== ""): ?>
        <p style="color: red"><?= e($error) ?></p>
    <?php elseif ($resultado !== null): ?>
        <p>Resultado: <strong><?= round($resultado, 4) ?></strong></p>
    <?php endif; ?>
</body>
</html>
