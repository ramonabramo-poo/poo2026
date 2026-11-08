<?php
declare(strict_types=1);

namespace Tienda\Catalogo;

// Ejercicio 09: un enum también vive en su namespace
enum Categoria: string
{
    case Informatica = "informatica";
    case Papeleria = "papeleria";

    public function etiqueta(): string
    {
        return match ($this) {
            Categoria::Informatica => "💻 Informática",
            Categoria::Papeleria => "📎 Papelería",
        };
    }
}
