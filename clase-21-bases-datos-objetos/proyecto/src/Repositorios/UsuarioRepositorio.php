<?php
declare(strict_types=1);

namespace App\Repositorios;

use App\Modelos\Usuario;
use PDO;

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
}
