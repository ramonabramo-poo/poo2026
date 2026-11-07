<?php
require "conexion.php";
echo "Conexión correcta con MySQL " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
