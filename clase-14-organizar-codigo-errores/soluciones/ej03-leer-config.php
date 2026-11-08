<?php
declare(strict_types=1);

function leerConfiguracion(string $ruta): array
{
    if (!file_exists($ruta)) {
        throw new RuntimeException("No existe el archivo de configuración: " . basename($ruta));
    }

    // JSON_THROW_ON_ERROR: si el JSON está mal escrito, lanza JsonException
    return json_decode(file_get_contents($ruta), true, 512, JSON_THROW_ON_ERROR);
}

// Preparamos dos archivos de prueba: uno bueno y otro roto
file_put_contents(__DIR__ . "/config-bien.json", '{"web": "Mi tienda", "iva": 0.21}');
file_put_contents(__DIR__ . "/config-mal.json", '{"web": "Mi tienda", "iva": }');

foreach (["config-bien.json", "config-mal.json", "config-no-existe.json"] as $archivo) {
    try {
        $config = leerConfiguracion(__DIR__ . "/" . $archivo);
        echo "✅ {$archivo}: web = {$config['web']}, IVA = {$config['iva']}<br>";
    } catch (JsonException $e) {
        echo "❌ {$archivo}: el JSON está mal escrito ({$e->getMessage()})<br>";
    } catch (RuntimeException $e) {
        echo "❌ {$archivo}: {$e->getMessage()}<br>";
    }
}
