<?php
require "conexion.php";

// Consulta preparada: el valor va aparte, en execute()
$stmt = $pdo->prepare("SELECT nombre, nota FROM alumnos WHERE nota >= :minima");
$stmt->execute(["minima" => 7]);

foreach ($stmt->fetchAll() as $a) {
    echo $a["nombre"] . " (" . $a["nota"] . ")<br>";
}
