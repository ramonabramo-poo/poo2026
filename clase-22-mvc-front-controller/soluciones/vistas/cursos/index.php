<h1><?= e($titulo) ?></h1>

<form method="get" action="/cursos" class="buscador">
    <input name="q" value="<?= e($busqueda) ?>" placeholder="Buscar por título…">
    <button class="boton">🔍 Buscar</button>
    <a href="/cursos/completos">Ver los completos</a>
</form>

<?php if (count($cursos) === 0): ?>
    <p>No hay cursos que mostrar.</p>
<?php else: ?>
    <table>
        <tr><th>Curso</th><th>Horas</th><th>Precio (IVA incl.)</th><th>Plazas</th></tr>
        <?php foreach ($cursos as $curso): ?>
            <tr>
                <td><a href="/cursos/<?= $curso->id ?>"><?= e($curso->titulo) ?></a></td>
                <td><?= $curso->horas ?></td>
                <td><?= euros($curso->precioConIva()) ?></td>
                <td><?= $curso->estaCompleto() ? "Completo" : $curso->plazas ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <nav class="paginacion">
        <?php for ($numero = 1; $numero <= $totalPaginas; $numero++): ?>
            <?php if ($numero === $pagina): ?>
                <strong><?= $numero ?></strong>
            <?php else: ?>
                <a href="/cursos?q=<?= urlencode($busqueda) ?>&amp;pagina=<?= $numero ?>"><?= $numero ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </nav>
<?php endif; ?>
