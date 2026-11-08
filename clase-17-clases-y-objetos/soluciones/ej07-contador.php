<?php
declare(strict_types=1);

class Contador
{
    // static: es de la CLASE, compartido por todos los contadores
    private static int $creados = 0;
    private int $valor = 0;

    public function __construct(private string $nombre)
    {
        self::$creados++;
    }

    public function incrementar(int $cuanto = 1): void
    {
        $this->valor += $cuanto;
    }

    public function reiniciar(): void
    {
        $this->valor = 0;
    }

    public function valor(): int
    {
        return $this->valor;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public static function creados(): int
    {
        return self::$creados;
    }
}

$visitas = new Contador("visitas");
$descargas = new Contador("descargas");

$visitas->incrementar();
$visitas->incrementar();
$descargas->incrementar(5);
$descargas->reiniciar();
$descargas->incrementar();

foreach ([$visitas, $descargas] as $contador) {
    echo "{$contador->nombre()}: {$contador->valor()}<br>";
}
echo "Contadores creados: " . Contador::creados();
