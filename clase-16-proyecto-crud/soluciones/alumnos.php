<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

function buscarAlumnos(PDO $pdo, string $busqueda): array
{
    $consulta = $pdo->prepare(
        "SELECT a.id, a.nombre, a.email, c.titulo AS curso
         FROM alumnos a
         INNER JOIN cursos c ON a.curso_id = c.id
         WHERE a.nombre LIKE :busqueda OR a.email LIKE :busqueda2
         ORDER BY a.nombre"
    );
    $consulta->execute(["busqueda" => "%{$busqueda}%", "busqueda2" => "%{$busqueda}%"]);
    return $consulta->fetchAll();
}

$titulo = "Alumnos";
$pdo = conectar();
$busqueda = trim($_GET["q"] ?? "");
$alumnos = buscarAlumnos($pdo, $busqueda);

require __DIR__ . "/includes/cabecera.php";
?>

<h1>🎒 Alumnos</h1>
<form class="buscador" method="get">
    <input name="q" value="<?= e($busqueda) ?>" placeholder="Buscar por nombre o email">
    <button class="boton">Buscar</button>
</form>
<?php if (usuarioConectado() !== null): ?>
    <p><a class="boton" href="alumno-crear.php">➕ Nuevo alumno</a></p>
<?php endif; ?>

<table>
    <tr><th>Nombre</th><th>Email</th><th>Curso</th><th></th></tr>
    <?php foreach ($alumnos as $alumno): ?>
        <tr>
            <td><?= e($alumno["nombre"]) ?></td>
            <td><?= e($alumno["email"]) ?></td>
            <td><?= e($alumno["curso"]) ?></td>
            <td>
                <?php if (usuarioConectado() !== null): ?>
                    <form class="en-linea" method="post" action="alumno-borrar.php" onsubmit="return confirm('¿Borrar a este alumno?')">
                        <input type="hidden" name="csrf" value="<?= tokenCsrf() ?>">
                        <input type="hidden" name="id" value="<?= $alumno["id"] ?>">
                        <button class="boton peligro">Borrar</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require __DIR__ . "/includes/pie.php"; ?>
