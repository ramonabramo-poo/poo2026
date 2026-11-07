<h1>🎓 <?= e($curso->titulo) ?></h1>

<ul>
    <li>Duración: <?= $curso->horas ?> horas</li>
    <li>Precio: <?= euros($curso->precioConIva()) ?> (IVA incluido)</li>
    <li>Plazas: <?= $curso->estaCompleto() ? "completo" : "quedan {$curso->plazas}" ?></li>
</ul>

<p>
    <a class="boton" href="/cursos/<?= $curso->id ?>/editar">✏️ Editar</a>
    <form method="post" action="/cursos/<?= $curso->id ?>/borrar" class="en-linea"
          onsubmit="return confirm('¿Seguro que quieres borrar este curso?')">
        <?= campoCsrf() ?>
        <button class="enlace peligro">🗑️ Borrar</button>
    </form>
</p>

<p><a href="/cursos">← Volver al catálogo</a></p>
