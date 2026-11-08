<?php
// Esta página recibe lo que se escribió en 17-formulario-saludo.html
$nombre = trim($_POST["nombre"] ?? "");
?>
<?php if ($nombre === ""): ?>
    <p>No has escrito tu nombre. <a href="17-formulario-saludo.html">Volver</a></p>
<?php else: ?>
    <p>¡Hola, <?php echo htmlspecialchars($nombre); ?>! 👋</p>
<?php endif; ?>
