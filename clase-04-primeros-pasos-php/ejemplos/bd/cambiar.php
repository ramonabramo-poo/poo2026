<?php
require "conexion.php";

// INSERT: añadir un alumno
$stmt = $pdo->prepare("INSERT INTO alumnos (nombre, email, nota)
                       VALUES (:nombre, :email, :nota)");
$stmt->execute(["nombre" => "Ana", "email" => "ana@ejemplo.com", "nota" => 9]);
echo "Nuevo id: " . $pdo->lastInsertId() . "<br>";

// UPDATE: cambiar una nota
$stmt = $pdo->prepare("UPDATE alumnos SET nota = :nota WHERE id = :id");
$stmt->execute(["nota" => 7.5, "id" => 2]);
echo $stmt->rowCount() . " fila(s) modificada(s)<br>";

// DELETE: borrar un alumno
$stmt = $pdo->prepare("DELETE FROM alumnos WHERE id = :id");
$stmt->execute(["id" => 3]);
echo $stmt->rowCount() . " fila(s) borrada(s)";
