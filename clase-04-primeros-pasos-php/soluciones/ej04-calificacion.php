<?php
$nota = 7.5;

// 1. Con if y llaves
if ($nota >= 9) {
    $conLlaves = "Sobresaliente";
} elseif ($nota >= 7) {
    $conLlaves = "Notable";
} elseif ($nota >= 5) {
    $conLlaves = "Aprobado";
} else {
    $conLlaves = "Suspenso";
}

// 3. Con match
$conMatch = match (true) {
    $nota >= 9 => "Sobresaliente",
    $nota >= 7 => "Notable",
    $nota >= 5 => "Aprobado",
    default => "Suspenso",
};
?>
<p>Con llaves: <?= $conLlaves ?></p>

<!-- 2. Con la sintaxis alternativa, directamente en el HTML -->
<p>Con sintaxis alternativa:
    <?php if ($nota >= 9): ?>
        Sobresaliente
    <?php elseif ($nota >= 7): ?>
        Notable
    <?php elseif ($nota >= 5): ?>
        Aprobado
    <?php else: ?>
        Suspenso
    <?php endif; ?>
</p>

<p>Con match: <?= $conMatch ?></p>
