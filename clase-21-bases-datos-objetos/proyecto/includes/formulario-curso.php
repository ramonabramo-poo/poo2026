<?php
// Formulario compartido por crear.php y editar.php.
// Espera $curso (un objeto Curso) y $errores.
use App\Web\Sesion;
?>
<form method="post" class="formulario">
    <input type="hidden" name="csrf" value="<?= Sesion::tokenCsrf() ?>">

    <label>Título
        <input name="titulo" value="<?= e($curso->titulo) ?>" required>
    </label>
    <small class="error"><?= e($errores["titulo"] ?? "") ?></small>

    <label>Horas
        <input type="number" name="horas" min="1" value="<?= $curso->horas ?>" required>
    </label>
    <small class="error"><?= e($errores["horas"] ?? "") ?></small>

    <label>Precio (€)
        <input type="number" name="precio" min="0" step="0.01" value="<?= $curso->precio ?>" required>
    </label>
    <small class="error"><?= e($errores["precio"] ?? "") ?></small>

    <label>Plazas libres
        <input type="number" name="plazas" min="0" value="<?= $curso->plazas ?>" required>
    </label>
    <small class="error"><?= e($errores["plazas"] ?? "") ?></small>

    <p>
        <button type="submit" class="boton">💾 Guardar</button>
        <a href="index.php">Cancelar</a>
    </p>
</form>
