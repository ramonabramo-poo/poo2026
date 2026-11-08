<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

function existeEmailAlumno(PDO $pdo, string $email): bool
{
    $consulta = $pdo->prepare("SELECT COUNT(*) FROM alumnos WHERE email = :email");
    $consulta->execute(["email" => $email]);
    return (int) $consulta->fetchColumn() > 0;
}

$titulo = "Nuevo alumno";
$errores = [];
$alumno = ["nombre" => "", "email" => "", "curso_id" => 0];

requerirLogin();
$pdo = conectar();
$cursos = $pdo->query("SELECT id, titulo FROM cursos ORDER BY titulo")->fetchAll();
$idsCursos = array_column($cursos, "id");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    comprobarCsrf($_POST["csrf"] ?? "");
    $alumno = [
        "nombre" => trim($_POST["nombre"] ?? ""),
        "email" => trim($_POST["email"] ?? ""),
        "curso_id" => (int) ($_POST["curso_id"] ?? 0),
    ];

    if (mb_strlen($alumno["nombre"]) < 2) {
        $errores["nombre"] = "Escribe el nombre.";
    }
    if (!filter_var($alumno["email"], FILTER_VALIDATE_EMAIL)) {
        $errores["email"] = "El email no es válido.";
    } elseif (existeEmailAlumno($pdo, $alumno["email"])) {
        $errores["email"] = "Ya hay un alumno con ese email.";
    }
    if (!in_array($alumno["curso_id"], $idsCursos, true)) {
        $errores["curso_id"] = "Elige un curso.";
    }

    if (count($errores) === 0) {
        $insertar = $pdo->prepare("INSERT INTO alumnos (nombre, email, curso_id) VALUES (:nombre, :email, :curso_id)");
        $insertar->execute($alumno);
        guardarMensaje("Alumno «{$alumno['nombre']}» dado de alta.");
        redirigir("alumnos.php");
    }
}

require __DIR__ . "/includes/cabecera.php";
?>

<h1>➕ Nuevo alumno</h1>
<form class="formulario" method="post">
    <input type="hidden" name="csrf" value="<?= tokenCsrf() ?>">

    <label>Nombre <input name="nombre" value="<?= e($alumno["nombre"]) ?>"></label>
    <?php if (isset($errores["nombre"])): ?><p class="error"><?= e($errores["nombre"]) ?></p><?php endif; ?>

    <label>Email <input name="email" value="<?= e($alumno["email"]) ?>"></label>
    <?php if (isset($errores["email"])): ?><p class="error"><?= e($errores["email"]) ?></p><?php endif; ?>

    <label>Curso
        <select name="curso_id">
            <option value="0">— Elige un curso —</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso["id"] ?>" <?= $curso["id"] === $alumno["curso_id"] ? "selected" : "" ?>><?= e($curso["titulo"]) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <?php if (isset($errores["curso_id"])): ?><p class="error"><?= e($errores["curso_id"]) ?></p><?php endif; ?>

    <button class="boton">Guardar</button>
</form>

<?php require __DIR__ . "/includes/pie.php"; ?>
