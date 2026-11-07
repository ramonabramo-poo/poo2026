<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Nucleo\Auth;
use App\Nucleo\Controlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;
use App\Nucleo\ValidacionException;

class AuthControlador extends Controlador
{
    // INYECCIÓN DE DEPENDENCIAS: el contenedor ve que pedimos un Auth y nos lo da
    public function __construct(private Auth $auth)
    {
    }

    // GET /login
    public function formulario(Peticion $peticion): Respuesta
    {
        if ($this->auth->comprobar()) {
            return $this->redirigir("/cursos");
        }
        return $this->vista("auth/login", ["titulo" => "Iniciar sesión"]);
    }

    // POST /login
    public function entrar(Peticion $peticion): Respuesta
    {
        $datos = $peticion->validar(["email" => "obligatorio|email", "clave" => "obligatorio"]);

        if (!$this->auth->intentar($datos["email"], $datos["clave"])) {
            // Mismo camino que un error de validación: volvemos al formulario con el aviso
            throw new ValidacionException(["email" => "Email o contraseña incorrectos."], ["email" => $datos["email"]], "/login");
        }

        return $this->redirigir("/cursos", "¡Hola, {$this->auth->usuario()?->nombre}!");
    }

    // POST /logout
    public function salir(Peticion $peticion): Respuesta
    {
        $this->auth->salir();
        return $this->redirigir("/cursos", "Has cerrado la sesión.");
    }
}
