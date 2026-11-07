<?php
declare(strict_types=1);

// ---------- Mostrar datos ----------

function e(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

// ---------- Redirecciones y mensajes ----------

// Redirige y PARA el programa (nunca olvidamos el exit)
function redirigir(string $destino): never
{
    header("Location: {$destino}");
    exit;
}

// Guarda un mensaje en la sesión para mostrarlo en la página siguiente ("mensaje flash")
function guardarMensaje(string $texto, string $tipo = "ok"): void
{
    $_SESSION["mensaje"] = ["texto" => $texto, "tipo" => $tipo];
}

// Devuelve el mensaje guardado (si hay) y lo borra para que solo se vea una vez
function leerMensaje(): ?array
{
    $mensaje = $_SESSION["mensaje"] ?? null;
    unset($_SESSION["mensaje"]);
    return $mensaje;
}

// ---------- Protección CSRF ----------

function tokenCsrf(): string
{
    if (empty($_SESSION["csrf"])) {
        $_SESSION["csrf"] = bin2hex(random_bytes(32));
    }
    return $_SESSION["csrf"];
}

function comprobarCsrf(string $tokenRecibido): void
{
    if (!hash_equals(tokenCsrf(), $tokenRecibido)) {
        http_response_code(403);
        exit("Petición no autorizada.");
    }
}

// ---------- Usuarios ----------

function usuarioConectado(): ?array
{
    return $_SESSION["usuario"] ?? null;
}

// El guardián: al principio de cada página privada
function requerirLogin(): void
{
    if (usuarioConectado() === null) {
        guardarMensaje("Inicia sesión para gestionar los cursos.", "error");
        redirigir("login.php");
    }
}

function buscarUsuarioPorEmail(PDO $pdo, string $email): ?array
{
    $consulta = $pdo->prepare("SELECT id, nombre, email, clave_hash FROM usuarios WHERE email = :email");
    $consulta->execute(["email" => $email]);
    return $consulta->fetch() ?: null;
}
