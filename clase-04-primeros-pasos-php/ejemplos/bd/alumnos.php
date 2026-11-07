<?php
require "conexion.php";

$errores = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $email  = trim($_POST["email"] ?? "");

    if ($nombre === "") { $errores[] = "El nombre es obligatorio."; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errores[] = "El email no es válido."; }

    if (empty($errores)) {
        $stmt = $pdo->prepare("INSERT INTO alumnos (nombre, email) VALUES (:n, :e)");
        $stmt->execute(["n" => $nombre, "e" => $email]);
    }
}
$alumnos = $pdo->query("SELECT nombre, email FROM alumnos ORDER BY nombre")->fetchAll();
?>
<?php foreach ($errores as $error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endforeach; ?>

<form method="post">
    Nombre: <input name="nombre"> Email: <input type="email" name="email">
    <button>Añadir</button>
</form>

<ul>
<?php foreach ($alumnos as $a): ?>
    <li><?= htmlspecialchars($a["nombre"]) ?> (<?= htmlspecialchars($a["email"]) ?>)</li>
<?php endforeach; ?>
</ul>
