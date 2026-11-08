<?php
declare(strict_types=1);

namespace App\Nucleo;

use App\Modelos\Usuario;

// El servicio de AUTENTICACIÓN: quién es el usuario conectado
class Auth
{
    private ?Usuario $usuario = null;

    public function intentar(string $email, string $clave): bool
    {
        $usuario = Usuario::primeroDonde("email", $email);

        if ($usuario === null || !$usuario->comprobarClave($clave)) {
            return false;
        }

        Sesion::regenerar();
        Sesion::guardar("usuario_id", $usuario->id);
        $this->usuario = $usuario;
        return true;
    }

    public function usuario(): ?Usuario
    {
        $id = Sesion::obtener("usuario_id");
        if ($this->usuario === null && $id !== null) {
            $this->usuario = Usuario::buscar((int) $id);
        }
        return $this->usuario;
    }

    public function comprobar(): bool
    {
        return $this->usuario() !== null;
    }

    public function salir(): void
    {
        Sesion::olvidar("usuario_id");
        Sesion::regenerar();
        $this->usuario = null;
    }
}
