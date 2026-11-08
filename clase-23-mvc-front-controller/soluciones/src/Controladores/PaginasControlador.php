<?php
declare(strict_types=1);

namespace App\Controladores;

class PaginasControlador
{
    // GET /acerca
    public function acerca(): string
    {
        return vista("paginas/acerca", ["titulo" => "Acerca de la academia", "seccion" => "acerca"]);
    }

    // Ejercicio 04. GET /contacto
    public function contacto(): string
    {
        return vista("paginas/contacto", [
            "titulo" => "Contacto",
            "seccion" => "contacto",
            "telefono" => "942 000 000",
            "email" => "info@academia-alpe.test",
            "horario" => ["Lunes a jueves" => "9:00 - 21:00", "Viernes" => "9:00 - 14:00"],
        ]);
    }
}
