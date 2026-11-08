<h1>📞 Contacto</h1>
<p>Teléfono: <?= e($telefono) ?> · Email: <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></p>

<h2>Horario</h2>
<table>
    <?php foreach ($horario as $dias => $horas): ?>
        <tr><td><?= e($dias) ?></td><td><?= e($horas) ?></td></tr>
    <?php endforeach; ?>
</table>
