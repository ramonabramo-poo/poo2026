<?php
declare(strict_types=1);

function leerVotos(string $archivo, array $opciones): array
{
    // Si es la primera vez, todos los votos a cero
    $votos = array_fill_keys(array_keys($opciones), 0);
    if (file_exists($archivo)) {
        $votos = json_decode(file_get_contents($archivo), true) ?? $votos;
    }
    return $votos;
}

function guardarVotos(string $archivo, array $votos): void
{
    file_put_contents($archivo, json_encode($votos), LOCK_EX);
}

$opciones = ["php" => "PHP", "js" => "JavaScript", "python" => "Python", "java" => "Java"];
$archivo = __DIR__ . "/datos/votos.json";
$porcentajes = [];

$votos = leerVotos($archivo, $opciones);
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$voto = $_POST["lenguaje"] ?? "";

if ($esEnvio) {
    if (array_key_exists($voto, $opciones)) {
        $votos[$voto]++;
        guardarVotos($archivo, $votos);
    }
    header("Location: ej02-encuesta.php");   // Post/Redirect/Get
    exit;
}

$total = array_sum($votos);
foreach ($opciones as $clave => $nombre) {
    $porcentajes[$clave] = $total > 0 ? round($votos[$clave] * 100 / $total) : 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Encuesta</title></head>
<body>
<h1>¿Qué lenguaje te gusta más?</h1>
<form method="post">
    <?php foreach ($opciones as $clave => $nombre): ?>
        <label><input type="radio" name="lenguaje" value="<?= $clave ?>"> <?= $nombre ?></label><br>
    <?php endforeach; ?>
    <button type="submit">Votar</button>
</form>

<h2>Resultados (<?= $total ?> votos)</h2>
<?php foreach ($opciones as $clave => $nombre): ?>
    <p><?= $nombre ?>: <?= $votos[$clave] ?> (<?= $porcentajes[$clave] ?> %)
        <br><span style="display:inline-block; height:12px; background:#4f7cff; width:<?= $porcentajes[$clave] * 3 ?>px"></span>
    </p>
<?php endforeach; ?>
</body>
</html>
