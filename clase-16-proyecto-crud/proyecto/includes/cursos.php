<?php
declare(strict_types=1);

// Todas las consultas de la tabla cursos, en un único archivo.
// Las páginas no escriben SQL: llaman a estas funciones.

function contarCursos(PDO $pdo, string $busqueda): int
{
    $consulta = $pdo->prepare("SELECT COUNT(*) FROM cursos WHERE titulo LIKE :busqueda");
    $consulta->execute(["busqueda" => "%{$busqueda}%"]);
    return (int) $consulta->fetchColumn();
}

function obtenerCursos(PDO $pdo, string $busqueda, int $pagina, int $porPagina): array
{
    $consulta = $pdo->prepare(
        "SELECT id, titulo, horas, precio, plazas
         FROM cursos
         WHERE titulo LIKE :busqueda
         ORDER BY titulo
         LIMIT :limite OFFSET :desde"
    );
    // En LIMIT y OFFSET, bindValue con PARAM_INT para que lleguen como números
    $consulta->bindValue("busqueda", "%{$busqueda}%", PDO::PARAM_STR);
    $consulta->bindValue("limite", $porPagina, PDO::PARAM_INT);
    $consulta->bindValue("desde", ($pagina - 1) * $porPagina, PDO::PARAM_INT);
    $consulta->execute();
    return $consulta->fetchAll();
}

function obtenerCurso(PDO $pdo, int $id): ?array
{
    $consulta = $pdo->prepare("SELECT id, titulo, horas, precio, plazas FROM cursos WHERE id = :id");
    $consulta->execute(["id" => $id]);
    return $consulta->fetch() ?: null;
}

function crearCurso(PDO $pdo, array $curso): int
{
    $consulta = $pdo->prepare(
        "INSERT INTO cursos (titulo, horas, precio, plazas) VALUES (:titulo, :horas, :precio, :plazas)"
    );
    $consulta->execute($curso);
    return (int) $pdo->lastInsertId();
}

function actualizarCurso(PDO $pdo, int $id, array $curso): void
{
    $consulta = $pdo->prepare(
        "UPDATE cursos SET titulo = :titulo, horas = :horas, precio = :precio, plazas = :plazas WHERE id = :id"
    );
    $consulta->execute($curso + ["id" => $id]);
}

function borrarCurso(PDO $pdo, int $id): bool
{
    $consulta = $pdo->prepare("DELETE FROM cursos WHERE id = :id");
    $consulta->execute(["id" => $id]);
    return $consulta->rowCount() === 1;
}

// Recoge los datos del formulario, ya limpios y con el tipo correcto
function leerFormularioCurso(array $post): array
{
    return [
        "titulo" => trim($post["titulo"] ?? ""),
        "horas" => (int) ($post["horas"] ?? 0),
        "precio" => (float) str_replace(",", ".", $post["precio"] ?? "0"),
        "plazas" => (int) ($post["plazas"] ?? 0),
    ];
}

// Devuelve los errores con el nombre del campo como clave
function validarCurso(array $curso): array
{
    $errores = [];
    if (mb_strlen($curso["titulo"]) < 3 || mb_strlen($curso["titulo"]) > 120) {
        $errores["titulo"] = "El título debe tener entre 3 y 120 caracteres.";
    }
    if ($curso["horas"] < 1 || $curso["horas"] > 1000) {
        $errores["horas"] = "Las horas deben estar entre 1 y 1000.";
    }
    if ($curso["precio"] < 0 || $curso["precio"] > 99999) {
        $errores["precio"] = "El precio no es válido.";
    }
    if ($curso["plazas"] < 0 || $curso["plazas"] > 500) {
        $errores["plazas"] = "Las plazas deben estar entre 0 y 500.";
    }
    return $errores;
}
