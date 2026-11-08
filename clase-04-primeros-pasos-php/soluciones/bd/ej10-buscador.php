<?php
require "conexion.php";

$q = trim($_GET["q"] ?? "");
$alumnos = [];

if ($q !== "") {
    // El texto del usuario va en un marcador, nunca pegado a la consulta
    $consulta = $pdo->prepare("SELECT nombre, email FROM alumnos WHERE nombre LIKE :texto ORDER BY nombre");
    $consulta->execute(["texto" => "%$q%"]);
    $alumnos = $consulta->fetchAll();
}
?>
<form method="get">
    <input name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Buscar por nombre">
    <button>Buscar</button>
</form>

<?php if ($q !== "" && count($alumnos) === 0): ?>
    <p>No hay alumnos que coincidan con «<?= htmlspecialchars($q) ?>».</p>
<?php endif; ?>

<ul>
    <?php foreach ($alumnos as $alumno): ?>
        <li><?= htmlspecialchars($alumno["nombre"]) ?> (<?= htmlspecialchars($alumno["email"]) ?>)</li>
    <?php endforeach; ?>
</ul>
