<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/funciones.php";

$titulo = "Inicio";
$pagina = "inicio";

require __DIR__ . "/includes/cabecera.php";
?>

<h1>Bienvenidos</h1>
<p>Esta página solo tiene el contenido que la hace distinta. La cabecera, el menú y el pie
   vienen de la carpeta <code>includes</code>.</p>

<?php require __DIR__ . "/includes/pie.php"; ?>
