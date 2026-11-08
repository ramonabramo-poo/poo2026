<h1>⛔ Método no permitido</h1>
<p>Esa dirección existe, pero no admite este tipo de petición.</p>
<?php if (isset($permitidos)): ?>
    <p>Métodos permitidos: <strong><?= e($permitidos) ?></strong></p>
<?php endif; ?>
<p><a href="/cursos">Ir al catálogo</a></p>
