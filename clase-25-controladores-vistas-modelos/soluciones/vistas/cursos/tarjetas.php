<h1>📚 Catálogo</h1>
<div class="tarjetas" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem;">
    <?php foreach ($cursos as $curso): ?>
        <?= parcial("cursos/_tarjeta", ["curso" => $curso]) ?>
    <?php endforeach; ?>
</div>
