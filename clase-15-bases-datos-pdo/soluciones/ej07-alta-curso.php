<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/includes/conexion.php";
require_once __DIR__ . "/../ejemplos/includes/funciones.php";

$errores = [];
$mensaje = isset($_GET["creado"]) ? "Curso creado con el id " . (int) $_GET["creado"] : "";

$titulo = trim($_POST["titulo"] ?? "");
$horas = $_POST["horas"] ?? "";
$precio = $_POST["precio"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($titulo === "") {
        $errores[] = "El título es obligatorio";
    }
    if (!is_numeric($horas) || (int) $horas <= 0) {
        $errores[] = "Las horas tienen que ser un número mayor que 0";
    }
    if (!is_numeric($precio) || (float) $precio < 0) {
        $errores[] = "El precio no puede ser negativo";
    }

    if (count($errores) === 0) {
        $pdo = conectar();
        $insertar = $pdo->prepare("INSERT INTO cursos (titulo, horas, precio) VALUES (:titulo, :horas, :precio)");
        $insertar->execute(["titulo" => $titulo, "horas" => (int) $horas, "precio" => (float) $precio]);

        header("Location: ej07-alta-curso.php?creado=" . $pdo->lastInsertId());
        exit;
    }
}
?>
<h1>Nuevo curso</h1>
<?php if ($mensaje !== ""): ?><p style="color: green"><?= e($mensaje) ?></p><?php endif; ?>
<?php foreach ($errores as $error): ?><p style="color: red"><?= e($error) ?></p><?php endforeach; ?>
<form method="post">
    <p><input name="titulo" placeholder="Título" value="<?= e($titulo) ?>"></p>
    <p><input name="horas" placeholder="Horas" value="<?= e($horas) ?>"></p>
    <p><input name="precio" placeholder="Precio" value="<?= e($precio) ?>"></p>
    <button>Crear</button>
</form>
