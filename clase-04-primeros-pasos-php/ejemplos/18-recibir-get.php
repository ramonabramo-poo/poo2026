<?php
// Recibe lo que se escribió en 17-formulario-get.html.
// Mirad la barra de direcciones: 18-recibir-get.php?nombre=Ana&ciudad=Santander
echo "Hola, " . $_GET["nombre"] . "<br>";
echo "Vives en " . $_GET["ciudad"];
