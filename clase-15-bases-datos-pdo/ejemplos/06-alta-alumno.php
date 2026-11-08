<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/conexion.php";
require_once __DIR__ . "/includes/funciones.php";

function validarAlumno(string $nombre, string $email, int $cursoId, array $cursos): array
{
    $errores = [];
    if (mb_strlen($nombre) < 2) {
        $errores[] = "Escribe el nombre.";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errores[] = "El email no es válido.";
    }
    if (!isset($cursos[$cursoId])) {
        $errores[] = "Elige un curso de la lista.";
    }
    return $errores;
}

$errores = [];
$nuevoId = 0;

$pdo = conectar();
// FETCH_KEY_PAIR: un array [id => titulo], perfecto para un <select>
$cursos = $pdo->query("SELECT id, titulo FROM cursos ORDER BY titulo")->fetchAll(PDO::FETCH_KEY_PAIR);
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$cursoId = (int) ($_POST["curso_id"] ?? 0);
$altaCorrecta = (int) ($_GET["nuevo"] ?? 0);

if ($esEnvio) {
    $errores = validarAlumno($nombre, $email, $cursoId, $cursos);

    if (count($errores) === 0) {
        try {
            $consulta = $pdo->prepare(
                "INSERT INTO alumnos (nombre, email, curso_id) VALUES (:nombre, :email, :cursoId)"
            );
            $consulta->execute(["nombre" => $nombre, "email" => $email, "cursoId" => $cursoId]);
            $nuevoId = (int) $pdo->lastInsertId();

            header("Location: 06-alta-alumno.php?nuevo={$nuevoId}");   // Post/Redirect/Get
            exit;
        } catch (PDOException $e) {
            // 1062 es el código de MySQL para «valor duplicado» (el email es UNIQUE)
            if (($e->errorInfo[1] ?? 0) === 1062) {
                $errores[] = "Ya hay un alumno con ese email.";
            } else {
                throw $e;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de alumno</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; max-width: 420px; }
        label { display: block; margin-top: .8rem; }
        input, select { width: 100%; padding: .3rem; }
    </style>
</head>
<body>
    <h1>Alta de alumno</h1>

    <?php if ($altaCorrecta > 0): ?>
        <p style="color: green">✅ Alumno guardado con el id <?= $altaCorrecta ?>.
            <a href="04-ficha-alumno.php?id=<?= $altaCorrecta ?>">Ver su ficha</a></p>
    <?php endif; ?>

    <?php if (count($errores) > 0): ?>
        <ul style="color: #b00020">
            <?php foreach ($errores as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post">
        <label>Nombre <input name="nombre" value="<?= e($nombre) ?>"></label>
        <label>Email <input name="email" value="<?= e($email) ?>"></label>
        <label>Curso
            <select name="curso_id">
                <option value="0">-- Elige --</option>
                <?php foreach ($cursos as $id => $titulo): ?>
                    <option value="<?= $id ?>" <?= $id === $cursoId ? "selected" : "" ?>><?= e($titulo) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <p><button type="submit">Guardar</button></p>
    </form>
</body>
</html>
