<?php
// Un for que genera las opciones de un desplegable
$anioActual = (int) date("Y");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Año de nacimiento</title>
</head>
<body>
    <label for="anio">Año de nacimiento</label>
    <select id="anio" name="anio">
        <?php for ($anio = $anioActual; $anio >= $anioActual - 100; $anio--): ?>
            <option value="<?= $anio ?>"><?= $anio ?></option>
        <?php endfor; ?>
    </select>
</body>
</html>
