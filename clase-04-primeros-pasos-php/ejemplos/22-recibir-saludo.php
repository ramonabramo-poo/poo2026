<?php
// Esta página recibe lo que se escribió en 21-formulario-saludo.html
$nombre = trim($_POST["nombre"] ?? "");
?>
<?php if ($nombre === ""): ?>
    <p>No has escrito tu nombre. <a href="21-formulario-saludo.html">Volver</a></p>
<?php else: ?>
    <p>¡Hola, <?php echo htmlspecialchars($nombre); ?>! 👋</p>
<?php endif; ?>
