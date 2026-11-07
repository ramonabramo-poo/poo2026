<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/conexion.php";
require_once __DIR__ . "/includes/funciones.php";

$pdo = conectar();
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$accion = $_POST["accion"] ?? "";
$id = (int) ($_POST["id"] ?? 0);
$nota = filter_var($_POST["nota"] ?? "", FILTER_VALIDATE_FLOAT);
$mensaje = $_GET["mensaje"] ?? "";

if ($esEnvio) {
    if ($accion === "nota" && $nota !== false && $nota >= 0 && $nota <= 10) {
        // UPDATE: ¡con su WHERE!
        $consulta = $pdo->prepare("UPDATE alumnos SET nota = :nota WHERE id = :id");
        $consulta->execute(["nota" => $nota, "id" => $id]);
        $mensaje = $consulta->rowCount() === 1 ? "Nota actualizada." : "No se ha cambiado nada.";
    } elseif ($accion === "nota") {
        $mensaje = "La nota debe ser un número entre 0 y 10.";
    } elseif ($accion === "borrar") {
        // DELETE: siempre por POST y siempre con WHERE
        $consulta = $pdo->prepare("DELETE FROM alumnos WHERE id = :id");
        $consulta->execute(["id" => $id]);
        $mensaje = $consulta->rowCount() === 1 ? "Alumno borrado." : "Ese alumno ya no existe.";
    }

    header("Location: 07-gestionar-notas.php?mensaje=" . urlencode($mensaje));
    exit;
}

$alumnos = $pdo->query("SELECT id, nombre, nota FROM alumnos ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; }
        td { padding: .3rem .6rem; border-bottom: 1px solid #ddd; }
        input[type=number] { width: 5rem; }
    </style>
</head>
<body>
    <h1>Gestión de notas</h1>
    <?php if ($mensaje !== ""): ?>
        <p><strong><?= e($mensaje) ?></strong></p>
    <?php endif; ?>

    <table>
        <?php foreach ($alumnos as $alumno): ?>
            <tr>
                <td><?= e($alumno["nombre"]) ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="accion" value="nota">
                        <input type="hidden" name="id" value="<?= $alumno["id"] ?>">
                        <input type="number" name="nota" step="0.01" min="0" max="10" value="<?= e($alumno["nota"]) ?>">
                        <button>Guardar</button>
                    </form>
                </td>
                <td>
                    <form method="post" onsubmit="return confirm('¿Seguro que quieres borrar a este alumno?')">
                        <input type="hidden" name="accion" value="borrar">
                        <input type="hidden" name="id" value="<?= $alumno["id"] ?>">
                        <button>🗑️ Borrar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
