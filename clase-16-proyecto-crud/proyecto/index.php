<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

$titulo = "Cursos";

$pdo = conectar();
$busqueda = trim($_GET["q"] ?? "");
$pagina = max(1, (int) ($_GET["pagina"] ?? 1));

$total = contarCursos($pdo, $busqueda);
$totalPaginas = max(1, (int) ceil($total / CURSOS_POR_PAGINA));
$pagina = min($pagina, $totalPaginas);
$cursos = obtenerCursos($pdo, $busqueda, $pagina, CURSOS_POR_PAGINA);
$puedeGestionar = usuarioConectado() !== null;

require __DIR__ . "/includes/cabecera.php";
?>

<h1>Catálogo de cursos</h1>

<form method="get" class="buscador">
    <input name="q" value="<?= e($busqueda) ?>" placeholder="Buscar por título…">
    <button class="boton">🔍 Buscar</button>
    <?php if ($busqueda !== ""): ?>
        <a href="index.php">Quitar filtro</a>
    <?php endif; ?>
</form>

<p><?= $total ?> curso(s)<?= $busqueda !== "" ? " para «" . e($busqueda) . "»" : "" ?></p>

<?php if ($total === 0): ?>
    <p>No hay cursos que coincidan con la búsqueda.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Curso</th><th>Horas</th><th>Precio</th><th>Plazas</th>
            <?php if ($puedeGestionar): ?><th>Acciones</th><?php endif; ?>
        </tr>
        <?php foreach ($cursos as $curso): ?>
            <tr>
                <td><?= e($curso["titulo"]) ?></td>
                <td><?= $curso["horas"] ?></td>
                <td><?= euros((float) $curso["precio"]) ?></td>
                <td><?= $curso["plazas"] > 0 ? $curso["plazas"] : "Completo" ?></td>
                <?php if ($puedeGestionar): ?>
                    <td class="acciones">
                        <a href="editar.php?id=<?= $curso["id"] ?>">✏️ Editar</a>
                        <form method="post" action="borrar.php" class="en-linea"
                              onsubmit="return confirm('¿Seguro que quieres borrar este curso?')">
                            <input type="hidden" name="csrf" value="<?= tokenCsrf() ?>">
                            <input type="hidden" name="id" value="<?= $curso["id"] ?>">
                            <button class="enlace peligro">🗑️ Borrar</button>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <nav class="paginacion">
        <?php for ($numero = 1; $numero <= $totalPaginas; $numero++): ?>
            <?php if ($numero === $pagina): ?>
                <strong><?= $numero ?></strong>
            <?php else: ?>
                <a href="?q=<?= urlencode($busqueda) ?>&amp;pagina=<?= $numero ?>"><?= $numero ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </nav>
<?php endif; ?>

<?php require __DIR__ . "/includes/pie.php"; ?>
