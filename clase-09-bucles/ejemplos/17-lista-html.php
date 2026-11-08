<?php
// Bucles dentro del HTML: foreach: ... endforeach;
$cursos = [
    ["titulo" => "PHP desde cero", "horas" => 60, "plazas" => 3],
    ["titulo" => "JavaScript moderno", "horas" => 50, "plazas" => 0],
    ["titulo" => "Diseño web", "horas" => 30, "plazas" => 12],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos</title>
    <style>
        .completo { color: #868e96; text-decoration: line-through; }
    </style>
</head>
<body>
    <h1>Nuestros cursos</h1>
    <ul>
        <?php foreach ($cursos as $curso): ?>
            <li class="<?= $curso["plazas"] === 0 ? "completo" : "" ?>">
                <?= $curso["titulo"] ?> (<?= $curso["horas"] ?> h)
                <?= $curso["plazas"] === 0 ? "· completo" : "· quedan {$curso["plazas"]} plazas" ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
