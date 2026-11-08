<?php
declare(strict_types=1);

// Ejercicio 09: la entidad Curso se puede probar SIN base de datos
// Ejecutadlo en la terminal: php prueba-curso.php
require __DIR__ . "/vendor/autoload.php";

use App\Modelos\Curso;

function comprobar(string $descripcion, bool $resultado): void
{
    echo ($resultado ? "✅ " : "❌ ") . $descripcion . PHP_EOL;
}

$bueno = new Curso(null, "PHP desde cero", 60, 100, 5);
$malo = new Curso(null, "PH", 0, -5, 20);
$completo = new Curso(1, "Laravel", 80, 300, 0);

comprobar("Un curso correcto es válido", $bueno->esValido());
comprobar("El precio con IVA de 100 € es 121 €", $bueno->precioConIva() === 121.0);
comprobar("Un título de 2 letras da error", isset($malo->errores()["titulo"]));
comprobar("Unas horas a 0 dan error", isset($malo->errores()["horas"]));
comprobar("Un precio negativo da error", isset($malo->errores()["precio"]));
comprobar("Con 0 plazas está completo", $completo->estaCompleto());
comprobar("desdeFormulario acepta la coma decimal", Curso::desdeFormulario(["precio" => "19,95"])->precio === 19.95);
