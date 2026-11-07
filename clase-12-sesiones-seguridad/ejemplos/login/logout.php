<?php
declare(strict_types=1);

session_start();

$_SESSION = [];       // 1. vaciar la taquilla
session_destroy();    // 2. destruir la sesión en el servidor

header("Location: login.php?salir=1");
exit;
