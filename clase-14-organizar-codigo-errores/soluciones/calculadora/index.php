<?php
declare(strict_types=1);

require_once __DIR__ . "/funciones.php";

$operaciones = ["+", "-", "*", "/"];
$resultado = "";
$error = "";

$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$a = $_POST["a"] ?? "";
$b = $_POST["b"] ?? "";
$operacion = $_POST["operacion"] ?? "+";

if ($esEnvio) {
    if (!is_numeric($a) || !is_numeric($b)) {
        $error = "Escribe dos números.";
    } else {
        try {
            $resultado = (string) round(calcular((float) $a, (float) $b, $operacion), 4);
        } catch (DivisionByZeroError | InvalidArgumentException $e) {
            $error = $e->getMessage();
        }
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
        <?php foreach ($operaciones as $op): ?>
            <option <?= $op === $operacion ? "selected" : "" ?>><?= $op ?></option>
        <?php endforeach; ?>
    </select>
    <input name="b" value="<?= e($b) ?>" size="6">
    <button>=</button>
    <strong><?= e($resultado) ?></strong>
</form>
<?php if ($error !== ""): ?><p style="color:red"><?= e($error) ?></p><?php endif; ?>
</body>
</html>
