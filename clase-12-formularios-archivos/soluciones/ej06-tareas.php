<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

function leerTareas(string $archivo): array
{
    return file_exists($archivo) ? (json_decode(file_get_contents($archivo), true) ?? []) : [];
}

function guardarTareas(string $archivo, array $tareas): void
{
    file_put_contents($archivo, json_encode($tareas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

$archivo = __DIR__ . "/datos/tareas.json";
$tareas = leerTareas($archivo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST["accion"] ?? "";
    $id = $_POST["id"] ?? "";

    if ($accion === "anadir" && trim($_POST["texto"] ?? "") !== "") {
        $tareas[uniqid()] = ["texto" => trim($_POST["texto"]), "hecha" => false];
    } elseif ($accion === "cambiar" && isset($tareas[$id])) {
        $tareas[$id]["hecha"] = !$tareas[$id]["hecha"];
    } elseif ($accion === "borrar") {
        unset($tareas[$id]);
    }

    guardarTareas($archivo, $tareas);
    header("Location: ej06-tareas.php");   // Post/Redirect/Get
    exit;
}

$pendientes = count(array_filter($tareas, fn (array $tarea): bool => !$tarea["hecha"]));
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Tareas</title></head>
<body>
    <h1>📝 Tareas (<?= $pendientes ?> <?= $pendientes === 1 ? "pendiente" : "pendientes" ?>)</h1>
    <form method="post">
        <input type="hidden" name="accion" value="anadir">
        <input name="texto" placeholder="Nueva tarea" required>
        <button>Añadir</button>
    </form>
    <ul>
        <?php foreach ($tareas as $id => $tarea): ?>
            <li>
                <form method="post" style="display: inline">
                    <input type="hidden" name="id" value="<?= e($id) ?>">
                    <button name="accion" value="cambiar"><?= $tarea["hecha"] ? "↩️" : "✅" ?></button>
                    <button name="accion" value="borrar">🗑️</button>
                </form>
                <?= $tarea["hecha"] ? "<s>" . e($tarea["texto"]) . "</s>" : e($tarea["texto"]) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
