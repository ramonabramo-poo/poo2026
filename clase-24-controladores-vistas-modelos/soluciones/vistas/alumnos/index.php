<h1>👥 Alumnos (<?= count($alumnos) ?>)</h1>
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
