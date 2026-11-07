<?php
declare(strict_types=1);

namespace App\Nucleo;

use PDO;

// MODELO BASE, un «mini ORM» al estilo de Eloquent (Active Record):
// cada objeto representa una fila y sabe guardarse y borrarse a sí mismo.
abstract class Modelo
{
    // Cada modelo hijo dice su tabla y sus columnas (con su tipo)
    protected static string $tabla;
    protected static array $columnas;    // ["titulo" => "string", "horas" => "int", ...]

    public ?int $id = null;

    /** @return static[] */
    public static function todos(string $ordenarPor = "id"): array
    {
        $columna = static::columnaPermitida($ordenarPor);
        $filas = static::pdo()->query("SELECT * FROM " . static::$tabla . " ORDER BY {$columna}")->fetchAll();
        return array_map(fn(array $fila) => static::desdeFila($fila), $filas);
    }

    public static function buscar(int $id): ?static
    {
        $consulta = static::pdo()->prepare("SELECT * FROM " . static::$tabla . " WHERE id = :id");
        $consulta->execute(["id" => $id]);
        $fila = $consulta->fetch();
        return $fila === false ? null : static::desdeFila($fila);
    }

    public static function contarDonde(string $columna, string $texto): int
    {
        $columna = static::columnaPermitida($columna);
        $consulta = static::pdo()->prepare("SELECT COUNT(*) FROM " . static::$tabla . " WHERE {$columna} LIKE :texto");
        $consulta->execute(["texto" => "%{$texto}%"]);
        return (int) $consulta->fetchColumn();
    }

    /** @return static[] */
    public static function paginaDonde(string $columna, string $texto, int $pagina, int $porPagina): array
    {
        $columna = static::columnaPermitida($columna);
        $consulta = static::pdo()->prepare(
            "SELECT * FROM " . static::$tabla . " WHERE {$columna} LIKE :texto
             ORDER BY {$columna} LIMIT :limite OFFSET :desde"
        );
        $consulta->bindValue("texto", "%{$texto}%");
        $consulta->bindValue("limite", $porPagina, PDO::PARAM_INT);
        $consulta->bindValue("desde", ($pagina - 1) * $porPagina, PDO::PARAM_INT);
        $consulta->execute();
        return array_map(fn(array $fila) => static::desdeFila($fila), $consulta->fetchAll());
    }

    // Rellena las propiedades con un array (por ejemplo, el del formulario)
    public function rellenar(array $datos): static
    {
        foreach (static::$columnas as $columna => $tipo) {
            if (array_key_exists($columna, $datos)) {
                $this->$columna = static::convertir($datos[$columna], $tipo);
            }
        }
        return $this;
    }

    // Sin id: INSERT. Con id: UPDATE. Igual que el guardar() de la clase 20
    public function guardar(): void
    {
        $nombres = array_keys(static::$columnas);
        $valores = [];
        foreach ($nombres as $columna) {
            $valores[$columna] = $this->$columna;
        }

        if ($this->id === null) {
            $marcadores = implode(", ", array_map(fn($c) => ":{$c}", $nombres));
            $sql = "INSERT INTO " . static::$tabla . " (" . implode(", ", $nombres) . ") VALUES ({$marcadores})";
            static::pdo()->prepare($sql)->execute($valores);
            $this->id = (int) static::pdo()->lastInsertId();
        } else {
            $asignaciones = implode(", ", array_map(fn($c) => "{$c} = :{$c}", $nombres));
            $sql = "UPDATE " . static::$tabla . " SET {$asignaciones} WHERE id = :id";
            static::pdo()->prepare($sql)->execute($valores + ["id" => $this->id]);
        }
    }

    public function borrar(): bool
    {
        $consulta = static::pdo()->prepare("DELETE FROM " . static::$tabla . " WHERE id = :id");
        $consulta->execute(["id" => $this->id]);
        return $consulta->rowCount() === 1;
    }

    protected static function desdeFila(array $fila): static
    {
        $modelo = new static();
        $modelo->id = (int) $fila["id"];
        return $modelo->rellenar($fila);
    }

    // Los nombres de columna NO pueden ir en marcadores: solo aceptamos los que conocemos
    protected static function columnaPermitida(string $columna): string
    {
        if ($columna !== "id" && !array_key_exists($columna, static::$columnas)) {
            throw new \InvalidArgumentException("Columna no permitida: {$columna}");
        }
        return $columna;
    }

    protected static function convertir(mixed $valor, string $tipo): mixed
    {
        return match ($tipo) {
            "int" => (int) $valor,
            "float" => (float) str_replace(",", ".", (string) $valor),
            "bool" => (bool) $valor,
            default => trim((string) $valor),
        };
    }

    protected static function pdo(): PDO
    {
        return BaseDatos::conexion();
    }
}
