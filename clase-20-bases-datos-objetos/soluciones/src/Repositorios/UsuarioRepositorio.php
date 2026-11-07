<?php
declare(strict_types=1);

namespace App\Repositorios;

use App\Modelos\Usuario;
use PDO;

// UsuarioRepositorio del proyecto, con el método nuevo crear()
class UsuarioRepositorio
{
    public function __construct(private PDO $pdo)
    {
    }

    public function buscarPorEmail(string $email): ?Usuario
    {
        $consulta = $this->pdo->prepare("SELECT id, nombre, email, clave_hash FROM usuarios WHERE email = :email");
        $consulta->execute(["email" => $email]);
        $fila = $consulta->fetch();
        return $fila === false ? null : Usuario::desdeFila($fila);
    }

    public function crear(string $nombre, string $email, string $clave): int
    {
        $consulta = $this->pdo->prepare(
            "INSERT INTO usuarios (nombre, email, clave_hash) VALUES (:nombre, :email, :hash)"
        );
        $consulta->execute([
            "nombre" => $nombre,
            "email" => $email,
            "hash" => password_hash($clave, PASSWORD_DEFAULT),
        ]);
        return (int) $this->pdo->lastInsertId();
    }
}
