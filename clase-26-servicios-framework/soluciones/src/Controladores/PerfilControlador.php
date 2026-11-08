<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Nucleo\Auth;
use App\Nucleo\Controlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

// Ejercicio 08: solo se llega aquí a través del middleware Autenticado
class PerfilControlador extends Controlador
{
    public function __construct(private Auth $auth)
    {
    }

    public function ver(Peticion $peticion): Respuesta
    {
        return $this->vista("paginas/perfil", ["titulo" => "Mi perfil", "usuario" => $this->auth->usuario()]);
    }
}
