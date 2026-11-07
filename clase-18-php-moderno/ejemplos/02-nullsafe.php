<?php
declare(strict_types=1);

class Direccion
{
    public function __construct(public string $ciudad, public string $pais)
    {
    }
}

class Usuario
{
    public function __construct(
        public string $nombre,
        public ?Direccion $direccion = null,   // puede no tener dirección
    ) {
    }

    public function getDireccion(): ?Direccion
    {
        return $this->direccion;
    }
}

$marta = new Usuario("Marta", new Direccion("Santander", "España"));
$luis = new Usuario("Luis");   // sin dirección

// SIN nullsafe: hay que comprobar el null antes de entrar
$ciudadLuis = "desconocida";
if ($luis->getDireccion() !== null) {
    $ciudadLuis = $luis->getDireccion()->ciudad;
}

// CON nullsafe: ?-> devuelve null si lo de la izquierda es null, sin error.
// Y con ?? le damos un valor por defecto.
$ciudadMarta = $marta->getDireccion()?->ciudad ?? "desconocida";
$ciudadLuis2 = $luis->getDireccion()?->ciudad ?? "desconocida";

echo "Marta vive en {$ciudadMarta}<br>";
echo "Luis vive en {$ciudadLuis} (con if) y en {$ciudadLuis2} (con ?->)<br>";

// Quitad las // y veréis el error de siempre: Attempt to read property "ciudad" on null
// echo $luis->getDireccion()->ciudad;
