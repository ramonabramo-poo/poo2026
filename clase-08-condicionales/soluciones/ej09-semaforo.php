<?php
$color = "ámbar";

$accion = match ($color) {
    "verde" => "Adelante",
    "ámbar", "amarillo" => "Frena si puedes hacerlo con seguridad",
    "rojo" => "Detente",
    default => "Color desconocido: ¡semáforo averiado!",
};

echo "Semáforo en $color: $accion";
