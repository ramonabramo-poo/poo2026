<h1>👥 Alumnos (<?= $total ?>)</h1>
<p>
    <a class="boton" href="/alumnos/crear">➕ Nuevo alumno</a>
    · Ordenar por:
    <?php foreach ($ordenes as $clave => $texto): ?>
        <?php if ($clave === $orden): ?>
            <strong><?= $texto ?></strong>
        <?php else: ?>
            <a href="/alumnos?orden=<?= $clave ?>"><?= $texto ?></a>
        <?php endif; ?>
    <?php endforeach; ?>
</p>
<table>
    <tr><th>Nombre</th><th>Email</th><th>Curso</th></tr>
    <?php foreach ($alumnos as $alumno): ?>
        <?php $curso = $alumno->curso(); ?>
        <tr>
            <td><?= e($alumno->nombre) ?></td>
            <td><?= e($alumno->email) ?></td>
            <td><a href="/cursos/<?= $alumno->curso_id ?>"><?= e($curso?->titulo ?? "—") ?></a></td>
        </tr>
    <?php endforeach; ?>
</table>
