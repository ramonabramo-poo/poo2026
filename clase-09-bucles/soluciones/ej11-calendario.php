<?php
// Un mes de 30 días que empieza en miércoles (3), en filas de 7
$diasDelMes = 30;
$empiezaEn = 3;   // 1 = lunes … 7 = domingo
$huecos = $empiezaEn - 1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario</title>
    <style>
        td, th { width: 2.5rem; height: 2rem; text-align: center; border: 1px solid #ddd; }
        .finde { background: #fff4e6; }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>L</th><th>M</th><th>X</th><th>J</th><th>V</th><th>S</th><th>D</th>
        </tr>
        <tr>
            <?php for ($i = 1; $i <= $huecos; $i++): ?>
                <td></td>
            <?php endfor; ?>
            <?php for ($dia = 1; $dia <= $diasDelMes; $dia++): ?>
                <?php $columna = ($huecos + $dia - 1) % 7 + 1; ?>
                <td class="<?= $columna >= 6 ? "finde" : "" ?>"><?= $dia ?></td>
                <?php if ($columna === 7 && $dia < $diasDelMes): ?>
                    </tr><tr>
                <?php endif; ?>
            <?php endfor; ?>
        </tr>
    </table>
</body>
</html>
