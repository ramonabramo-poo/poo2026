<?php
// Los datos de un formulario GET viajan en la URL: buscar-get.php?q=php
$q = trim($_GET["q"] ?? "");
?>
<form method="get">
    <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>">
    <button type="submit">Buscar</button>
</form>

<?php if ($q !== ""): ?>
    <p>Has buscado: <strong><?php echo htmlspecialchars($q); ?></strong></p>
    <p>Fijaos en la barra de direcciones: el dato aparece en la URL.</p>
<?php endif; ?>
