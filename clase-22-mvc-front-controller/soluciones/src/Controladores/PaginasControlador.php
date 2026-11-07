<?php
declare(strict_types=1);

namespace App\Controladores;

class PaginasControlador
{
    // GET /acerca
    public function acerca(): string
    {
        return vista("paginas/acerca", ["titulo" => "Acerca de la academia"]);
    }
}
