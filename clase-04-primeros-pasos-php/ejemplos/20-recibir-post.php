<?php
// Recibe lo que se escribió en 19-formulario-post.html.
// Esta vez la URL no cambia: los datos llegan en $_POST
echo "Usuario: " . $_POST["usuario"] . "<br>";
echo "La contraseña tiene " . strlen($_POST["clave"]) . " caracteres";
