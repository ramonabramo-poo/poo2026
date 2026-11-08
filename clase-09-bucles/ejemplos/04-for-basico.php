<?php
// for: inicio; condición; paso. Ideal cuando sabemos cuántas vueltas hay que dar
for ($i = 1; $i <= 10; $i++) {
    echo "$i ";
}
echo "<br>";

// De 2 en 2
for ($i = 0; $i <= 20; $i += 2) {
    echo "$i ";
}
echo "<br>";

// Cuenta atrás
for ($i = 10; $i >= 0; $i--) {
    echo $i === 0 ? "¡Despegue! 🚀" : "$i... ";
}
