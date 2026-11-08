<h1>🎓 <?= e($curso->titulo) ?></h1>

<ul>
    <li>Duración: <?= $curso->horas ?> horas</li>
    <li>Precio: <?= euros($curso->precioConIva()) ?> (IVA incluido)</li>
    <li>Plazas: <?= $curso->estaCompleto() ? "completo" : "quedan {$curso->plazas}" ?></li>
</ul>

<?php if (count($relacionados) > 0): ?>
    <!-- Ejercicio 09 -->
    <h2>Con un precio parecido</h2>
    <ul>
        <?php foreach ($relacionados as $otro): ?>
            <li><a href="/cursos/<?= $otro->id ?>"><?= e($otro->titulo) ?></a> (<?= euros($otro->precioConIva()) ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p><a href="/cursos">← Volver al catálogo</a> · <a href="/cursos/<?= $curso->id ?>/json">Ver en JSON</a></p>
