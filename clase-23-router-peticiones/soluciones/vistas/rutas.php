<h1>🗺️ Rutas registradas</h1>
<table>
    <tr><th>Método</th><th>Ruta</th><th>La atiende</th></tr>
    <?php foreach ($rutas as $ruta): ?>
        <tr>
            <td><?= e($ruta["metodo"]) ?></td>
            <td><code><?= e($ruta["ruta"]) ?></code></td>
            <td><?= e($ruta["accion"]) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
