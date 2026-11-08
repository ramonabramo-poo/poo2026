<?php
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int) ($_POST["id"] ?? 0);
    $borrar = $pdo->prepare("DELETE FROM alumnos WHERE id = :id");
    $borrar->execute(["id" => $id]);

    // Volvemos a la misma página con un GET: así recargar no repite el borrado
    header("Location: ej11-gestion.php");
    exit;
}

$alumnos = $pdo->query("SELECT id, nombre, nota FROM alumnos ORDER BY nombre")->fetchAll();
?>
<h1>Gestión de alumnos</h1>
<table border="1" cellpadding="6">
    <?php foreach ($alumnos as $alumno): ?>
        <tr>
            <td><?= htmlspecialchars($alumno["nombre"]) ?></td>
            <td><?= $alumno["nota"] ?></td>
            <td>
                <form method="post" onsubmit="return confirm('¿Borrar a este alumno?')">
                    <input type="hidden" name="id" value="<?= $alumno["id"] ?>">
                    <button>Borrar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
