<?php
// try: "intenta hacer esto"; catch: "si algo falla, haz esto otro"
try {
    $pdo = new PDO("mysql:host=localhost;dbname=academia;charset=utf8mb4", "root", "");

    echo "<p>¡Conectados con MySQL!</p>";

    $consulta = $pdo->query("SELECT nombre, nota FROM alumnos");

    foreach ($consulta as $fila) {
        echo $fila["nombre"] . ": " . $fila["nota"] . "<br>";
    }
} catch (PDOException $e) {
    // Si la conexión o la consulta fallan, llegamos aquí en lugar de ver un error fatal
    echo "<p>No se ha podido conectar con la base de datos.</p>";
    echo "<p>Motivo: " . $e->getMessage() . "</p>";
}
