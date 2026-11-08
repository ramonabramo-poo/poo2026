<?php
require "conexion.php";

$alumnos = $pdo->query("SELECT id, nombre, email, nota FROM alumnos ORDER BY nombre")->fetchAll();
?>
<h1>Alumnos</h1>
<table border="1" cellpadding="6">
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Nota</th>
    </tr>
    <?php foreach ($alumnos as $alumno): ?>
        <tr>
            <td><?= htmlspecialchars($alumno["nombre"]) ?></td>
            <td><?= htmlspecialchars($alumno["email"]) ?></td>
            <td><?= $alumno["nota"] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
