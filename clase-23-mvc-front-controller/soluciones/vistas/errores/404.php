<h1>🔍 No encontramos esa página</h1>
<?php if (isset($rutaPedida)): ?>
    <p>La dirección <code><?= e($rutaPedida) ?></code> no existe en nuestra web.</p>
<?php endif; ?>
<p>¿Buscabas un curso? Prueba con el buscador:</p>
<form method="get" action="/cursos" class="buscador">
    <input name="q" placeholder="Buscar por título…">
    <button class="boton">🔍 Buscar</button>
</form>
<p><a href="/cursos">Ir al catálogo de cursos</a> · <a href="/cursos/aleatorio">Sorpréndeme 🎲</a></p>
