<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/includes/conexion.php";
require_once __DIR__ . "/../ejemplos/includes/funciones.php";

$pdo = conectar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $borrar = $pdo->prepare("DELETE FROM alumnos WHERE id = :id");
    $borrar->execute(["id" => (int) ($_POST["id"] ?? 0)]);
    // rowCount() dice cuántas filas se han borrado
    header("Location: ej09-borrar-alumno.php?borrados=" . $borrar->rowCount());
    exit;
}

$borrados = $_GET["borrados"] ?? null;
$alumnos = $pdo->query("SELECT id, nombre FROM alumnos ORDER BY nombre")->fetchAll();
?>
<h1>Borrar alumnos</h1>
<?php if ($borrados !== null): ?>
    <p><?= (int) $borrados === 1 ? "Alumno borrado." : "No se ha borrado nada." ?></p>
<?php endif; ?>
<ul>
    <?php foreach ($alumnos as $alumno): ?>
        <li>
            <?= e($alumno["nombre"]) ?>
            <form method="post" style="display: inline" onsubmit="return confirm('¿Seguro?')">
                <input type="hidden" name="id" value="<?= $alumno["id"] ?>">
                <button>Borrar</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
