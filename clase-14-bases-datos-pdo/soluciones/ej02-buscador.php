<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/includes/conexion.php";
require_once __DIR__ . "/../ejemplos/includes/funciones.php";

$alumnos = [];

$texto = trim($_GET["q"] ?? "");

if ($texto !== "") {
    $pdo = conectar();
    $consulta = $pdo->prepare(
        "SELECT a.id, a.nombre, a.email, c.titulo AS curso
         FROM alumnos a
         INNER JOIN cursos c ON a.curso_id = c.id
         WHERE a.nombre LIKE :texto
         ORDER BY a.nombre"
    );
    // Los % van en el dato, no en el SQL
    $consulta->execute(["texto" => "%{$texto}%"]);
    $alumnos = $consulta->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscador de alumnos</title>
</head>
<body>
    <h1>🔍 Buscador de alumnos</h1>
    <form method="get">
        <input name="q" value="<?= e($texto) ?>" placeholder="Nombre o parte del nombre">
        <button>Buscar</button>
    </form>

    <?php if ($texto !== ""): ?>
        <p><?= count($alumnos) ?> resultado(s) para «<?= e($texto) ?>»</p>
        <ul>
            <?php foreach ($alumnos as $alumno): ?>
                <li><?= e($alumno["nombre"]) ?> · <?= e($alumno["email"]) ?> · <?= e($alumno["curso"]) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
