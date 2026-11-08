<?php
$numero = 8;
?>
<h1>Tabla del <?= $numero ?></h1>
<table border="1" cellpadding="6">
    <?php for ($i = 1; $i <= 10; $i++): ?>
        <tr>
            <td><?= $numero ?> × <?= $i ?></td>
            <td><?= $numero * $i ?></td>
        </tr>
    <?php endfor; ?>
</table>
