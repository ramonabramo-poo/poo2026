<?php
$errores = [];
$nombre = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $email  = trim($_POST["email"] ?? "");

    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }
}
?>
<?php if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($errores)): ?>
    <p>Gracias, <?php echo htmlspecialchars($nombre); ?>.</p>
<?php else: ?>
    <?php foreach ($errores as $error): ?>
        <p style="color:red"><?php echo $error; ?></p>
    <?php endforeach; ?>
    <form method="post">
        Nombre: <input type="text" name="nombre"
                       value="<?php echo htmlspecialchars($nombre); ?>">
        Email: <input type="email" name="email">
        <button type="submit">Enviar</button>
    </form>
<?php endif; ?>
