<?php
// var_export() escribe true o false como texto (echo de false no muestra nada)
$a1 = 0;
$b1 = "0";
$a2 = 1;
$b2 = true;
$a3 = "10";
$b3 = "1e1";
$a4 = null;
$b4 = false;
?>
<table border="1" cellpadding="6">
    <tr><th>A</th><th>B</th><th>A == B</th><th>A === B</th></tr>
    <tr><td>0</td><td>"0"</td><td><?= var_export($a1 == $b1, true) ?></td><td><?= var_export($a1 === $b1, true) ?></td></tr>
    <tr><td>1</td><td>true</td><td><?= var_export($a2 == $b2, true) ?></td><td><?= var_export($a2 === $b2, true) ?></td></tr>
    <tr><td>"10"</td><td>"1e1"</td><td><?= var_export($a3 == $b3, true) ?></td><td><?= var_export($a3 === $b3, true) ?></td></tr>
    <tr><td>null</td><td>false</td><td><?= var_export($a4 == $b4, true) ?></td><td><?= var_export($a4 === $b4, true) ?></td></tr>
</table>
<p>Moraleja: con <code>==</code> pasan cosas raras. Usad siempre <code>===</code>.</p>
