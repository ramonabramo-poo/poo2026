<?php
$logueado = false;   // cambiadlo a true y recargad
?>
<!DOCTYPE html>
<html lang="es">
<body>
    <h1>Llaves o sintaxis alternativa</h1>

    <h2>Con llaves</h2>
    <?php if ($logueado) { ?>
        <p>Bienvenido</p>
    <?php } else { ?>
        <a href="login.php">Entrar</a>
    <?php } ?>

    <h2>Con sintaxis alternativa</h2>
    <?php if ($logueado): ?>
        <p>Bienvenido</p>
    <?php else: ?>
        <a href="login.php">Entrar</a>
    <?php endif; ?>
</body>
</html>
