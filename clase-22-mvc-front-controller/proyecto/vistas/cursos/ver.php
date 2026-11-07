<h1>🎓 <?= e($curso->titulo) ?></h1>

<ul>
    <li>Duración: <?= $curso->horas ?> horas</li>
    <li>Precio: <?= euros($curso->precioConIva()) ?> (IVA incluido)</li>
    <li>Plazas: <?= $curso->estaCompleto() ? "completo" : "quedan {$curso->plazas}" ?></li>
</ul>

<p><a href="/cursos">← Volver al catálogo</a></p>
