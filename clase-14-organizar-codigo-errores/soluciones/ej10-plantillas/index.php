<?php
declare(strict_types=1);

// Incluye una plantilla pasándole SOLO los datos que necesita
function mostrarPlantilla(string $ruta, array $datos): void
{
    // extract() convierte ["titulo" => "Ofertas"] en la variable $titulo
    extract($datos);
    require $ruta;
}

mostrarPlantilla(__DIR__ . "/plantillas/pagina.php", [
    "titulo" => "Ofertas de la semana",
    "productos" => ["Teclado", "Ratón", "Monitor"],
]);
