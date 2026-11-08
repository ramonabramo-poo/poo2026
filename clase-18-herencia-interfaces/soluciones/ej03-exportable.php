<?php
declare(strict_types=1);

// El contrato: cualquier objeto Exportable sabe convertirse en una fila de datos
interface Exportable
{
    public function cabeceras(): array;
    public function aFila(): array;
}

// Dos clases que NO son familia, pero firman el mismo contrato
class Producto implements Exportable
{
    public function __construct(private string $nombre, private float $precio)
    {
    }

    public function cabeceras(): array
    {
        return ["Producto", "Precio"];
    }

    public function aFila(): array
    {
        return [$this->nombre, number_format($this->precio, 2, ",", "")];
    }
}

class Alumno implements Exportable
{
    public function __construct(private string $nombre, private string $email, private float $nota)
    {
    }

    public function cabeceras(): array
    {
        return ["Nombre", "Email", "Nota"];
    }

    public function aFila(): array
    {
        return [$this->nombre, $this->email, (string) $this->nota];
    }
}

// Sirve para productos, para alumnos y para cualquier clase futura que sea Exportable
function aCsv(array $elementos): string
{
    if (count($elementos) === 0) {
        return "";
    }
    $lineas = [implode(";", $elementos[0]->cabeceras())];
    foreach ($elementos as $elemento) {
        $lineas[] = implode(";", $elemento->aFila());
    }
    return implode("\n", $lineas);
}

$productos = [new Producto("Camiseta", 15), new Producto("Taza", 7.95)];
$alumnos = [new Alumno("Marta", "marta@ejemplo.com", 8.5), new Alumno("Luis", "luis@ejemplo.com", 6)];

echo "<h2>Productos</h2><pre>" . htmlspecialchars(aCsv($productos)) . "</pre>";
echo "<h2>Alumnos</h2><pre>" . htmlspecialchars(aCsv($alumnos)) . "</pre>";
