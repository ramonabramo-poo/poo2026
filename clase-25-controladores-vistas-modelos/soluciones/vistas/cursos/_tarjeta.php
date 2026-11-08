<?php // Vista PARCIAL: una tarjeta. Recibe $curso ?>
<article class="tarjeta">
    <h2><a href="/cursos/<?= $curso->id ?>"><?= e($curso->titulo) ?></a></h2>
    <p><?= $curso->horas ?> horas · <?= euros($curso->precioConIva()) ?></p>
    <p class="<?= $curso->estaCompleto() ? "error" : "" ?>"><?= e($curso->etiquetaPlazas()) ?></p>
</article>
