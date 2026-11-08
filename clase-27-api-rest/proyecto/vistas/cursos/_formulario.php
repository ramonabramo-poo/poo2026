<?php // Vista PARCIAL: el formulario que comparten crear y editar ?>
<form method="post" action="<?= e($accion) ?>" class="formulario">
    <?= campoCsrf() ?>

    <label>Título
        <input name="titulo" value="<?= e(viejo("titulo", $curso->titulo)) ?>">
    </label>
    <small class="error"><?= e(error("titulo")) ?></small>

    <label>Horas
        <input type="number" name="horas" value="<?= e(viejo("horas", $curso->horas)) ?>">
    </label>
    <small class="error"><?= e(error("horas")) ?></small>

    <label>Precio (€)
        <input name="precio" value="<?= e(viejo("precio", $curso->precio)) ?>">
    </label>
    <small class="error"><?= e(error("precio")) ?></small>

    <label>Plazas libres
        <input type="number" name="plazas" value="<?= e(viejo("plazas", $curso->plazas)) ?>">
    </label>
    <small class="error"><?= e(error("plazas")) ?></small>

    <p>
        <button type="submit" class="boton">💾 Guardar</button>
        <a href="/cursos">Cancelar</a>
    </p>
</form>
