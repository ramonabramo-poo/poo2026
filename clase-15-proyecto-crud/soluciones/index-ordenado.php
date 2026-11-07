<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

// Los nombres de columna NO pueden ir en un marcador (:orden).
// Por eso usamos una lista blanca: solo aceptamos valores que conocemos.
const ORDENES = [
    "titulo" => "titulo ASC",
    "precio" => "precio ASC",
    "precio-desc" => "precio DESC",
    "horas" => "horas DESC",
];

function obtenerCursosOrdenados(PDO $pdo, string $busqueda, string $orden, int $pagina, int $porPagina): array
{
    $ordenSql = ORDENES[$orden] ?? ORDENES["titulo"];
    $consulta = $pdo->prepare(
        "SELECT id, titulo, horas, precio, plazas FROM cursos
         WHERE titulo LIKE :busqueda
         ORDER BY {$ordenSql}
         LIMIT :limite OFFSET :desde"
    );
    $consulta->bindValue("busqueda", "%{$busqueda}%", PDO::PARAM_STR);
    $consulta->bindValue("limite", $porPagina, PDO::PARAM_INT);
    $consulta->bindValue("desde", ($pagina - 1) * $porPagina, PDO::PARAM_INT);
    $consulta->execute();
    return $consulta->fetchAll();
}

$titulo = "Cursos";
$etiquetas = ["titulo" => "Título", "precio" => "Más baratos", "precio-desc" => "Más caros", "horas" => "Más horas"];

$pdo = conectar();
$busqueda = trim($_GET["q"] ?? "");
$orden = $_GET["orden"] ?? "titulo";
$pagina = max(1, (int) ($_GET["pagina"] ?? 1));

if (!isset(ORDENES[$orden])) {
    $orden = "titulo";
}
$total = contarCursos($pdo, $busqueda);
$totalPaginas = max(1, (int) ceil($total / CURSOS_POR_PAGINA));
$pagina = min($pagina, $totalPaginas);
$cursos = obtenerCursosOrdenados($pdo, $busqueda, $orden, $pagina, CURSOS_POR_PAGINA);

require __DIR__ . "/includes/cabecera.php";
?>

<h1>Catálogo de cursos</h1>

<form method="get" class="buscador">
    <input name="q" value="<?= e($busqueda) ?>" placeholder="Buscar por título…">
    <select name="orden">
        <?php foreach ($etiquetas as $valor => $texto): ?>
            <option value="<?= $valor ?>" <?= $valor === $orden ? "selected" : "" ?>><?= $texto ?></option>
        <?php endforeach; ?>
    </select>
    <button class="boton">Aplicar</button>
</form>

<table>
    <tr><th>Curso</th><th>Horas</th><th>Precio</th><th>Plazas</th></tr>
    <?php foreach ($cursos as $curso): ?>
        <tr>
            <td><?= e($curso["titulo"]) ?></td>
            <td><?= $curso["horas"] ?></td>
            <td><?= euros((float) $curso["precio"]) ?></td>
            <td><?= $curso["plazas"] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<nav class="paginacion">
    <?php for ($numero = 1; $numero <= $totalPaginas; $numero++): ?>
        <?php if ($numero === $pagina): ?>
            <strong><?= $numero ?></strong>
        <?php else: ?>
            <a href="?q=<?= urlencode($busqueda) ?>&amp;orden=<?= $orden ?>&amp;pagina=<?= $numero ?>"><?= $numero ?></a>
        <?php endif; ?>
    <?php endfor; ?>
</nav>

<?php require __DIR__ . "/includes/pie.php"; ?>
