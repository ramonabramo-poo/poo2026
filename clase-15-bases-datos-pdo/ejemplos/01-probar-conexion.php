<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/conexion.php";

$pdo = conectar();

// Si llegamos aquí, la conexión ha funcionado
$version = $pdo->query("SELECT VERSION()")->fetchColumn();

echo "✅ Conectado a la base de datos " . DB_NOMBRE . "<br>";
echo "Versión del servidor: {$version}";
