<?php
declare(strict_types=1);

namespace App\Nucleo;

// Un MIDDLEWARE se coloca entre la petición y el controlador.
// Puede dejar pasar la petición ($siguiente) o cortarla y responder él.
interface Middleware
{
    public function procesar(Peticion $peticion, callable $siguiente): Respuesta;
}
