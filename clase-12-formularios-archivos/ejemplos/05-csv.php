<?php
declare(strict_types=1);

$archivo = __DIR__ . "/datos/alumnos.csv";
$alumnos = [
    ["nombre", "edad", "ciudad"],   // cabecera
    ["Marta", 22, "Santander"],
    ["Luis", 31, "Torrelavega"],
    ["Ana", 19, "Laredo"],
];
$filas = [];

// ESCRIBIR: cada array se convierte en una línea separada por ;
$f = fopen($archivo, "w");          // "w" = escribir (borra lo que hubiera)
foreach ($alumnos as $alumno) {
    fputcsv($f, $alumno, ";", '"', "\\");
}
fclose($f);

// LEER: cada línea vuelve a ser un array
$f = fopen($archivo, "r");          // "r" = leer
while (($fila = fgetcsv($f, null, ";", '"', "\\")) !== false) {
    $filas[] = $fila;
}
fclose($f);
?>
<table border="1" cellpadding="4">
    <?php foreach ($filas as $fila): ?>
        <tr>
            <?php foreach ($fila as $celda): ?>
                <td><?= htmlspecialchars($celda) ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>
