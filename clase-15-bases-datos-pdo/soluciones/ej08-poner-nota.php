<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/includes/conexion.php";
require_once __DIR__ . "/../ejemplos/includes/funciones.php";

$pdo = conectar();
$mensaje = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int) ($_POST["id"] ?? 0);
    $nota = trim($_POST["nota"] ?? "");

    if ($nota !== "" && (!is_numeric($nota) || (float) $nota < 0 || (float) $nota > 10)) {
        $error = "La nota tiene que estar entre 0 y 10 (o vacía para quitarla)";
    } else {
        $actualizar = $pdo->prepare("UPDATE alumnos SET nota = :nota WHERE id = :id");
        // Una nota vacía se guarda como NULL ("sin nota")
        $actualizar->execute(["nota" => $nota === "" ? null : (float) $nota, "id" => $id]);
        $mensaje = $actualizar->rowCount() === 1 ? "Nota guardada" : "No ha cambiado nada";
    }
}

$alumnos = $pdo->query("SELECT id, nombre, nota FROM alumnos ORDER BY nombre")->fetchAll();
?>
<h1>Poner notas</h1>
<?php if ($mensaje !== ""): ?><p style="color: green"><?= e($mensaje) ?></p><?php endif; ?>
<?php if ($error !== ""): ?><p style="color: red"><?= e($error) ?></p><?php endif; ?>
<form method="post">
    <select name="id">
        <?php foreach ($alumnos as $alumno): ?>
            <option value="<?= $alumno["id"] ?>"><?= e($alumno["nombre"]) ?> (<?= e($alumno["nota"] ?? "sin nota") ?>)</option>
        <?php endforeach; ?>
    </select>
    <input name="nota" placeholder="Nota">
    <button>Guardar</button>
</form>
