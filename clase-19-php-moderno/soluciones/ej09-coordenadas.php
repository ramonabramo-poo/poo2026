<?php
declare(strict_types=1);

// Clase readonly: TODAS sus propiedades son de solo lectura
final readonly class Coordenada
{
    public function __construct(
        public float $latitud,
        public float $longitud,
    ) {
        if ($latitud < -90 || $latitud > 90 || $longitud < -180 || $longitud > 180) {
            throw new InvalidArgumentException("Coordenadas fuera de rango");
        }
    }

    public function igualA(Coordenada $otra): bool
    {
        return $this->latitud === $otra->latitud && $this->longitud === $otra->longitud;
    }

    public function __toString(): string
    {
        return "{$this->latitud}, {$this->longitud}";
    }
}

$santander = new Coordenada(43.4623, -3.8099);
$otraVez = new Coordenada(43.4623, -3.8099);
$madrid = new Coordenada(40.4168, -3.7038);

echo "Santander: $santander<br>";
echo "== compara los datos: " . var_export($santander == $otraVez, true) . "<br>";
echo "=== compara si es el MISMO objeto: " . var_export($santander === $otraVez, true) . "<br>";
echo "igualA(): " . var_export($santander->igualA($madrid), true);
