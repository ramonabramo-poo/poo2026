<?php
declare(strict_types=1);

$textos = [
    "es" => ["titulo" => "¡Bienvenidos!", "texto" => "Este es el curso de PHP."],
    "en" => ["titulo" => "Welcome!",      "texto" => "This is the PHP course."],
    "fr" => ["titulo" => "Bienvenue !",   "texto" => "Voici le cours de PHP."],
];

$idiomaElegido = $_GET["idioma"] ?? "";
$idioma = $_COOKIE["idioma"] ?? "es";

if (isset($textos[$idiomaElegido])) {
    setcookie("idioma", $idiomaElegido, [
        "expires" => time() + 60 * 60 * 24 * 365,
        "path" => "/",
        "httponly" => true,
        "samesite" => "Lax",
    ]);
    header("Location: ej02-idioma.php");
    exit;
}

if (!isset($textos[$idioma])) {
    $idioma = "es";   // nunca nos fiamos de una cookie: el usuario puede cambiarla
}
?>
<!DOCTYPE html>
<html lang="<?= $idioma ?>">
<head><meta charset="UTF-8"><title><?= $textos[$idioma]["titulo"] ?></title></head>
<body>
<p><a href="?idioma=es">ES</a> · <a href="?idioma=en">EN</a> · <a href="?idioma=fr">FR</a></p>
<h1><?= $textos[$idioma]["titulo"] ?></h1>
<p><?= $textos[$idioma]["texto"] ?></p>
</body>
</html>
