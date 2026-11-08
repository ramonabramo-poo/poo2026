<?php
// foreach: recorre TODOS los elementos sin preocuparnos de índices
$alumnos = ["Lucía", "Pablo", "Marta", "Iván"];

foreach ($alumnos as $alumno) {
    echo "Hola, $alumno<br>";
}

// Si también queremos la posición:
foreach ($alumnos as $posicion => $alumno) {
    echo "$posicion → $alumno<br>";
}
