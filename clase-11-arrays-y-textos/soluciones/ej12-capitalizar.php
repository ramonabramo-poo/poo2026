<?php
declare(strict_types=1);

function capitalizarNombre(string $nombre): string
{
    $menores = ["de", "del", "la", "las", "los", "y"];
    $palabras = explode(" ", mb_strtolower(trim($nombre)));
    $resultado = [];

    foreach ($palabras as $posicion => $palabra) {
        if ($palabra === "") {
            continue;   // espacios dobles
        }
        // "de", "la"… van en minúscula, salvo si son la primera palabra
        $resultado[] = in_array($palabra, $menores, true) && $posicion > 0
            ? $palabra
            : mb_strtoupper(mb_substr($palabra, 0, 1)) . mb_substr($palabra, 1);
    }

    return implode(" ", $resultado);
}

echo capitalizarNombre("ana MARÍA  de la fuente") . "<br>";
echo capitalizarNombre("ÁLVARO del río y ruiz");
