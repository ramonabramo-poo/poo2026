<?php
declare(strict_types=1);

// Simulamos lo que un usuario malintencionado escribe en un formulario
$comentario = "<script>alert('¡Te he hackeado!')</script>";

echo "<h2>❌ Sin proteger</h2>";
echo "<p>Mirad el código fuente: el script está ahí, listo para ejecutarse.</p>";
// No lo imprimimos de verdad para no molestaros con la alerta:
echo "<pre>" . htmlspecialchars("<p>" . $comentario . "</p>") . "</pre>";

echo "<h2>✅ Protegido con htmlspecialchars()</h2>";
echo "<p>" . htmlspecialchars($comentario, ENT_QUOTES, "UTF-8") . "</p>";
// En pantalla se ve el texto, pero el navegador NO lo ejecuta:
// los < y > se han convertido en &lt; y &gt;
