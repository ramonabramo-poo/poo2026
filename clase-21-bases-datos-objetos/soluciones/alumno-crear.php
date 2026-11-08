<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

use App\BaseDatos\Conexion;
use App\Excepciones\EmailDuplicadoException;
use App\Repositorios\AlumnoRepositorio;
use App\Repositorios\CursoRepositorio;

$titulo = "Nuevo alumno";
$error = "";

$pdo = Conexion::obtener();
$alumnosRepo = new AlumnoRepositorio($pdo);
$cursos = (new CursoRepositorio($pdo))->buscar("", 1, 100);

$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$cursoId = (int) ($_POST["curso_id"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($nombre === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || $cursoId === 0) {
        $error = "Rellena el nombre, un email válido y el curso.";
    } else {
        try {
            $alumno = $alumnosRepo->crear($nombre, $email, $cursoId);
            redirigir("alumnos.php");
        } catch (EmailDuplicadoException $excepcion) {
            // Ejercicio 08: el repositorio traduce el error de MySQL a algo que entendemos
            $error = $excepcion->getMessage();
        }
    }
}

require __DIR__ . "/includes/cabecera.php";
?>

<h1>➕ Nuevo alumno</h1>
<?php if ($error !== ""): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form class="formulario" method="post">
    <label>Nombre <input name="nombre" value="<?= e($nombre) ?>"></label>
    <label>Email <input name="email" value="<?= e($email) ?>"></label>
    <label>Curso
        <select name="curso_id">
            <option value="0">— Elige —</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso->id ?>" <?= $curso->id === $cursoId ? "selected" : "" ?>><?= e($curso->titulo) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <button class="boton">Guardar</button>
</form>

<?php require __DIR__ . "/includes/pie.php"; ?>
