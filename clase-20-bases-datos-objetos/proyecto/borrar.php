<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

use App\BaseDatos\Conexion;
use App\Excepciones\CursoConAlumnosException;
use App\Repositorios\CursoRepositorio;
use App\Web\Sesion;

Sesion::requerirLogin();
$cursosRepo = new CursoRepositorio(Conexion::obtener());
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$id = (int) ($_POST["id"] ?? 0);

if (!$esEnvio) {
    http_response_code(405);
    exit("Método no permitido.");
}

Sesion::comprobarCsrf($_POST["csrf"] ?? "");

try {
    if ($cursosRepo->borrar($id)) {
        Sesion::guardarMensaje("Curso borrado.");
    } else {
        Sesion::guardarMensaje("Ese curso ya no existe.", "error");
    }
} catch (CursoConAlumnosException $e) {
    Sesion::guardarMensaje($e->getMessage(), "error");
}

redirigir("index.php");
