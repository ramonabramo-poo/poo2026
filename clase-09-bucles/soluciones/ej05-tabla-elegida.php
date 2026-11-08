<?php
// Probad: ej05-tabla-elegida.php?tabla=9
$tabla = (int) ($_GET["tabla"] ?? 1);

if ($tabla < 1 || $tabla > 10) {
    $error = "Elegid una tabla del 1 al 10";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla del <?= $tabla ?></title>
    <style>
        td { border: 1px solid #ccc; padding: 4px 10px; text-align: right; }
    </style>
</head>
<body>
    <?php if (isset($error)): ?>
        <p><?= $error ?></p>
    <?php else: ?>
        <h1>Tabla del <?= $tabla ?></h1>
        <table>
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <tr>
                    <td><?= $tabla ?> × <?= $i ?></td>
                    <td><?= $tabla * $i ?></td>
                </tr>
            <?php endfor; ?>
        </table>
    <?php endif; ?>
</body>
</html>
