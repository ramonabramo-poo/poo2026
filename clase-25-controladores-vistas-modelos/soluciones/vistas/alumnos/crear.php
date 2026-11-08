<h1>➕ Nuevo alumno</h1>
<form method="post" action="/alumnos" class="formulario">
    <?= campoCsrf() ?>

    <label>Nombre <input name="nombre" value="<?= e($alumno->nombre) ?>"></label>
    <small class="error"><?= e($errores["nombre"] ?? "") ?></small>

    <label>Email <input name="email" value="<?= e($alumno->email) ?>"></label>
    <small class="error"><?= e($errores["email"] ?? "") ?></small>

    <label>Curso
        <select name="curso_id">
            <option value="0">— Elige un curso —</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso->id ?>" <?= $curso->id === $alumno->curso_id ? "selected" : "" ?>><?= e($curso->titulo) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <small class="error"><?= e($errores["curso_id"] ?? "") ?></small>

    <button class="boton">Guardar</button>
</form>
