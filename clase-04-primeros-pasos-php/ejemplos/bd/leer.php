<?php
require "conexion.php";

$consulta = $pdo->query("SELECT nombre, nota FROM alumnos");

foreach ($consulta as $fila) {
    echo $fila["nombre"] . ": " . $fila["nota"] . "<br>";
}
