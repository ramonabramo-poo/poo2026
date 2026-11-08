<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Modelos\Usuario;
use App\Nucleo\Auth;
use App\Nucleo\Controlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

class RegistroControlador extends Controlador
{
    public function __construct(private Auth $auth)
    {
    }

    // GET /registro
    public function formulario(Peticion $peticion): Respuesta
    {
        return $this->vista("auth/registro", ["titulo" => "Crear cuenta"]);
    }

    // POST /registro
    public function guardar(Peticion $peticion): Respuesta
    {
        $datos = $peticion->validar([
            "nombre" => "obligatorio|min:2|max:80",
            "email" => "obligatorio|email|unico:usuarios,email",
            "clave" => "obligatorio|min:8",
            "clave2" => "obligatorio|igual:clave",
        ]);

        $usuario = (new Usuario())->rellenar([
            "nombre" => $datos["nombre"],
            "email" => $datos["email"],
            "clave_hash" => password_hash($datos["clave"], PASSWORD_DEFAULT),
        ]);
        $usuario->guardar();

        $this->auth->intentar($datos["email"], $datos["clave"]);   // y ya entra directamente
        return $this->redirigir("/cursos", "¡Bienvenido/a, {$usuario->nombre}! Tu cuenta está creada.");
    }
}
