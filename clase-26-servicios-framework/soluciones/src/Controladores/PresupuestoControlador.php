<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Modelos\Curso;
use App\Nucleo\Controlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;
use App\Servicios\CalculadoraPrecios;

// Ejercicio 07: el contenedor nos inyecta la calculadora ya configurada
class PresupuestoControlador extends Controlador
{
    public function __construct(private CalculadoraPrecios $calculadora)
    {
    }

    // GET /cursos/{id}/presupuesto?descuento=10
    public function calcular(Peticion $peticion, int $id): Respuesta
    {
        $curso = Curso::buscar($id) ?? $this->noEncontrado("Ese curso no existe.");
        $descuento = (int) $peticion->consulta("descuento", "0");

        return Respuesta::texto(
            "«{$curso->titulo}» pidiendo un {$descuento} % de descuento (máximo 30 %): " . euros($this->calculadora->total($curso->precio, $descuento)) . " (IVA incluido)"
        );
    }
}
