<?php
$nombre = "Lucía";
?>
<!DOCTYPE html>
<html lang="es">
<body>
    <h1>Mi primera página PHP</h1>

    <!-- Forma larga: abrimos PHP, usamos echo y cerramos con ; -->
    <p>Hoy es <?php echo date("d/m/Y"); ?></p>

    <!-- Echo corto: hace lo mismo, pero sin "echo" ni punto y coma -->
    <p>Hoy es <?= date("d/m/Y") ?></p>
    <p>Bienvenida, <?= $nombre ?></p>
</body>
</html>
