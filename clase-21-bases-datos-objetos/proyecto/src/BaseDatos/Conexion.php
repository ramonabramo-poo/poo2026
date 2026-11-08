<?php
declare(strict_types=1);

namespace App\BaseDatos;

use PDO;
use PDOException;

// Una única conexión para toda la petición: se crea la primera vez que se pide
class Conexion
{
    private static ?PDO $pdo = null;

    public static function obtener(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = self::conectar();
        }
        return self::$pdo;
    }

    private static function conectar(): PDO
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NOMBRE . ";charset=utf8mb4";
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            return new PDO($dsn, DB_USUARIO, DB_CLAVE, $opciones);
        } catch (PDOException $e) {
            http_response_code(500);
            exit("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }
}
