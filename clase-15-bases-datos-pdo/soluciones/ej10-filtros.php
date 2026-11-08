<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/includes/conexion.php";
require_once __DIR__ . "/../ejemplos/includes/funciones.php";

$pdo = conectar();
$ciudades = $pdo->query("SELECT DISTINCT ciudad FROM alumnos ORDER BY ciudad")->fetchAll(PDO::FETCH_COLUMN);

$ciudad = $_GET["ciudad"] ?? "";
$soloAprobados = isset($_GET["aprobados"]);

// Montamos el WHERE poco a poco, pero los VALORES siempre van como parámetros
$condiciones = [];
$parametros = [];
if ($ciudad !== "") {
    $condiciones[] = "ciudad = :ciudad";
    $parametros["ciudad"] = $ciudad;
}
if ($soloAprobados) {
    $condiciones[] = "nota >= 5";
}

$sql = "SELECT nombre, ciudad, nota FROM alumnos";
if (count($condiciones) > 0) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY nombre";

$consulta = $pdo->prepare($sql);
$consulta->execute($parametros);
$alumnos = $consulta->fetchAll();
?>
<form method="get">
    <select name="ciudad">
        <option value="">Todas las ciudades</option>
        <?php foreach ($ciudades as $opcion): ?>
            <option <?= $opcion === $ciudad ? "selected" : "" ?>><?= e($opcion) ?></option>
        <?php endforeach; ?>
    </select>
    <label><input type="checkbox" name="aprobados" <?= $soloAprobados ? "checked" : "" ?>> Solo aprobados</label>
    <button>Filtrar</button>
</form>
<p><?= count($alumnos) ?> resultados</p>
<ul>
    <?php foreach ($alumnos as $alumno): ?>
        <li><?= e($alumno["nombre"]) ?> (<?= e($alumno["ciudad"]) ?>): <?= e($alumno["nota"] ?? "sin nota") ?></li>
    <?php endforeach; ?>
</ul>
