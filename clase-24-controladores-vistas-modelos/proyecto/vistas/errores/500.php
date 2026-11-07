<h1>😕 Vaya, algo ha fallado</h1>
<p>Estamos trabajando en ello. Inténtalo de nuevo en unos minutos.</p>

<?php if ($detalle !== null): ?>
    <!-- Solo se ve con DEPURACION = true -->
    <pre class="mensaje error"><strong><?= e(get_class($detalle)) ?>:</strong> <?= e($detalle->getMessage()) ?>

<?= e($detalle->getFile()) ?>:<?= $detalle->getLine() ?></pre>
<?php endif; ?>
