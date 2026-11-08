<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

use App\BaseDatos\Conexion;
use App\Repositorios\EstadisticasRepositorio;

$titulo = "Estadísticas";
$estadisticas = new EstadisticasRepositorio(Conexion::obtener());

require __DIR__ . "/includes/cabecera.php";
?>

<h1>📊 Estadísticas</h1>
<ul>
    <li>Plazas libres en total: <?= $estadisticas->totalPlazasLibres() ?></li>
    <li>Precio medio: <?= euros($estadisticas->precioMedio()) ?></li>
</ul>

<h2>Los tres más caros</h2>
<ol>
    <?php foreach ($estadisticas->masCaros(3) as $curso): ?>
        <!-- Son objetos Curso: podemos usar sus métodos -->
        <li><?= e($curso->titulo) ?>: <?= euros($curso->precioConIva()) ?> con IVA</li>
    <?php endforeach; ?>
</ol>

<h2>Cursos completos</h2>
<ul>
    <?php foreach ($estadisticas->completos() as $curso): ?>
        <li><?= e($curso->titulo) ?></li>
    <?php endforeach; ?>
</ul>

<?php require __DIR__ . "/includes/pie.php"; ?>
