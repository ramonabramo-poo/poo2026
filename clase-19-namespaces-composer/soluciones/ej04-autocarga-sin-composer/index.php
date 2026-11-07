<?php
declare(strict_types=1);

// Clases SIN namespace: cada clase está en clases/NombreDeLaClase.php
spl_autoload_register(function (string $clase): void {
    $archivo = __DIR__ . "/clases/{$clase}.php";
    if (file_exists($archivo)) {
        require $archivo;
    }
});

// Fijaos: cargamos Profesor PRIMERO y funciona igual.
// Al ver "extends Usuario", PHP pide Usuario a la autocarga en ese momento.
$usuarios = [new Profesor("Ramón"), new Alumno("Marta")];

foreach ($usuarios as $usuario) {
    echo "{$usuario->nombre}: {$usuario->obtenerRol()}<br>";
}
