<?php
declare(strict_types=1);

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $producto = trim($_POST["producto"] ?? "");
    // Guardamos el mensaje en la sesión, redirigimos... y se mostrará UNA vez
    $_SESSION["flash"] = $producto === ""
        ? ["tipo" => "error", "texto" => "Escribe un producto"]
        : ["tipo" => "ok", "texto" => "«{$producto}» añadido a la lista"];
    header("Location: ej07-mensajes-flash.php");
    exit;
}

// Leer y borrar: así, al recargar, el mensaje ya no sale
$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Mensajes flash</title></head>
<body>
    <?php if ($flash !== null): ?>
        <p style="color: <?= $flash["tipo"] === "ok" ? "green" : "red" ?>"><?= htmlspecialchars($flash["texto"]) ?></p>
    <?php endif; ?>
    <form method="post">
        <input name="producto" placeholder="Producto">
        <button>Añadir</button>
    </form>
</body>
</html>
