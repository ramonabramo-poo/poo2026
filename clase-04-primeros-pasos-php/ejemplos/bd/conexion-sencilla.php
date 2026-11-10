<?php
// 1) Conectar: tipo de base de datos, servidor, nombre de la base y caracteres; usuario; contraseña
$pdo = new PDO("mysql:host=localhost;dbname=academia;charset=utf8mb4", "root", "");

echo "<p>¡Conectados con MySQL!</p>";

// 2) Pedir datos con una consulta SQL fija
$consulta = $pdo->query("SELECT nombre, email, nota FROM alumnos");

// 3) Recorrer las filas: cada una es un array con los datos de un alumno
foreach ($consulta as $fila) {
    echo $fila["nombre"] . " (" . $fila["email"] . "): " . $fila["nota"] . "<br>";
}
