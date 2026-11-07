<?php
declare(strict_types=1);

// Datos de conexión de Laragon: usuario root sin contraseña
const DB_HOST = "localhost";
const DB_NOMBRE = "academia_alpe";
const DB_USUARIO = "root";
const DB_CLAVE = "";

// Devuelve una conexión PDO lista para usar, o para el programa con un mensaje claro
function conectar(): PDO
{
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NOMBRE . ";charset=utf8mb4";
    $opciones = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,         // los errores, como excepciones
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,    // cada fila, como array asociativo
        PDO::ATTR_EMULATE_PREPARES => false,                 // consultas preparadas de verdad
    ];

    try {
        return new PDO($dsn, DB_USUARIO, DB_CLAVE, $opciones);
    } catch (PDOException $e) {
        // En una web publicada, este mensaje iría al registro de errores, no a la pantalla
        http_response_code(500);
        exit("Error al conectar con la base de datos: " . $e->getMessage());
    }
}
