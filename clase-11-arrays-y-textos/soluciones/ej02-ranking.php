<?php
declare(strict_types=1);

$notas = ["Marta" => 8.5, "Luis" => 4.2, "Ana" => 9.1, "Pedro" => 6.8];

arsort($notas);

echo "<h2>Ranking</h2><ol>";
foreach ($notas as $nombre => $nota) {
    echo "<li>{$nombre}: {$nota}</li>";
}
echo "</ol>";

echo "Media: " . round(array_sum($notas) / count($notas), 2);
