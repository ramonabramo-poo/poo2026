<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tablas de multiplicar</title>
    <style>
        table { border-collapse: collapse; }
        td, th { border: 1px solid #999; padding: 4px 8px; text-align: right; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>Tablas del 1 al 10</h1>
    <table>
        <tr>
            <th>×</th>
            <?php for ($col = 1; $col <= 10; $col++): ?>
                <th><?= $col ?></th>
            <?php endfor; ?>
        </tr>
        <?php for ($fila = 1; $fila <= 10; $fila++): ?>
            <tr>
                <th><?= $fila ?></th>
                <?php for ($col = 1; $col <= 10; $col++): ?>
                    <td><?= $fila * $col ?></td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
</body>
</html>
