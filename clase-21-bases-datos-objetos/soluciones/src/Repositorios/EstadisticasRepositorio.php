<?php
declare(strict_types=1);

namespace App\Repositorios;

use App\Modelos\Curso;
use PDO;

// Ejercicio 05: un repositorio solo de consultas de resumen
class EstadisticasRepositorio
{
    public function __construct(private PDO $pdo)
    {
    }

    public function totalPlazasLibres(): int
    {
        return (int) $this->pdo->query("SELECT COALESCE(SUM(plazas), 0) FROM cursos")->fetchColumn();
    }

    public function precioMedio(): float
    {
        return (float) $this->pdo->query("SELECT COALESCE(AVG(precio), 0) FROM cursos")->fetchColumn();
    }

    /** @return Curso[] */
    public function completos(): array
    {
        $filas = $this->pdo->query("SELECT id, titulo, horas, precio, plazas FROM cursos WHERE plazas = 0 ORDER BY titulo")->fetchAll();
        return array_map(fn (array $fila) => Curso::desdeFila($fila), $filas);
    }

    /** @return Curso[] */
    public function masCaros(int $cuantos): array
    {
        $consulta = $this->pdo->prepare("SELECT id, titulo, horas, precio, plazas FROM cursos ORDER BY precio DESC LIMIT :cuantos");
        $consulta->bindValue("cuantos", $cuantos, PDO::PARAM_INT);
        $consulta->execute();
        return array_map(fn (array $fila) => Curso::desdeFila($fila), $consulta->fetchAll());
    }
}
