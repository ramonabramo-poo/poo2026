<?php
declare(strict_types=1);

// Enum puro (sin valor): una lista cerrada de opciones
enum Talla
{
    case S;
    case M;
    case L;
    case XL;

    public function centimetrosPecho(): string
    {
        return match ($this) {
            Talla::S => "86-91",
            Talla::M => "94-99",
            Talla::L => "102-107",
            Talla::XL => "110-115",
        };
    }
}

// Con un enum como tipo, nadie puede pasarnos "XXXL" ni "mediana"
function etiqueta(Talla $talla): string
{
    return "Talla {$talla->name}: pecho de {$talla->centimetrosPecho()} cm";
}

foreach (Talla::cases() as $talla) {
    echo etiqueta($talla) . "<br>";
}
