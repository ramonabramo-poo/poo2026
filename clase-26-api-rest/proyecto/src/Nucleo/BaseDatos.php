<?php
declare(strict_types=1);

namespace App\Nucleo;

use PDO;

// La Conexion de la clase 20, ahora leyendo los datos del .env
class BaseDatos
{
    private static ?PDO $pdo = null;

    public static function conexion(): PDO
    {
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . Entorno::obtener("DB_HOST", "localhost")
                . ";dbname=" . Entorno::obtener("DB_NOMBRE")
                . ";charset=utf8mb4";
            self::$pdo = new PDO($dsn, Entorno::obtener("DB_USUARIO"), Entorno::obtener("DB_CLAVE"), [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }
        return self::$pdo;
    }
}
