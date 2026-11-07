<?php
declare(strict_types=1);

// SOLO para este ejemplo metemos varios namespaces en un archivo.
// En la vida real: un namespace por archivo, al principio.

namespace App\Modelos {
    // Nuestro Usuario: el de la base de datos de la academia
    class Usuario
    {
        public function __construct(public string $nombre)
        {
        }

        public function describir(): string
        {
            return "Usuario de la academia: {$this->nombre}";
        }
    }
}

namespace Foro\Entidades {
    // El Usuario de una librería de foros que hemos descargado. ¡Mismo nombre!
    class Usuario
    {
        public function __construct(public string $alias)
        {
        }

        public function describir(): string
        {
            return "Usuario del foro: @{$this->alias}";
        }
    }
}

namespace {
    // Aquí estamos en el espacio "global", el de siempre

    use App\Modelos\Usuario;                        // "Usuario" a secas será el nuestro
    use Foro\Entidades\Usuario as UsuarioForo;      // y el del foro, con un alias

    $marta = new Usuario("Marta García");
    $martaEnElForo = new UsuarioForo("marta_dev");
    $nombreCompleto = new \App\Modelos\Usuario("Luis Pérez");   // también con el nombre completo

    echo $marta->describir() . "<br>";
    echo $martaEnElForo->describir() . "<br>";
    echo $nombreCompleto->describir() . "<br>";
    echo "El nombre completo de la clase es: " . Usuario::class;   // App\Modelos\Usuario
}
