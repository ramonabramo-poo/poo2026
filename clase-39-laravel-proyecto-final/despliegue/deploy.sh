#!/bin/bash
# Actualiza la academia en el servidor: bash deploy.sh
# Se ejecuta dentro de la carpeta del proyecto, con el usuario del servidor web
set -e

echo "🚧 Modo mantenimiento"
php artisan down --retry=60

echo "📥 Bajando el código nuevo"
git pull origin main

echo "📦 Instalando dependencias (sin las de desarrollo)"
composer install --no-dev --optimize-autoloader --no-interaction

echo "🗃️ Migraciones"
php artisan migrate --force

echo "⚡ Cachés de configuración, rutas, vistas y eventos"
php artisan optimize

echo "🔁 Reiniciando los workers de la cola"
php artisan queue:restart

echo "✅ Fuera del modo mantenimiento"
php artisan up
