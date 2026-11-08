<?php
declare(strict_types=1);

// Un ENUM es un tipo con una lista CERRADA de valores posibles
enum Talla
{
    case S;
    case M;
    case L;
    case XL;
}

function precioCamiseta(Talla $talla): float
{
    // match + enum: si falta algún caso, PHP lo avisa (UnhandledMatchError)
    return match ($talla) {
        Talla::S, Talla::M => 15.0,
        Talla::L => 17.0,
        Talla::XL => 19.0,
    };
}

$miTalla = Talla::L;

echo "Talla {$miTalla->name}: " . precioCamiseta($miTalla) . " €<br>";

// Todas las tallas posibles
foreach (Talla::cases() as $talla) {
    echo "{$talla->name} ";
}
echo "<br>";

var_dump($miTalla === Talla::L);   // bool(true): se comparan con ===

// Quitad las // y veréis el TypeError: "L" es un texto, no una Talla
// precioCamiseta("L");
