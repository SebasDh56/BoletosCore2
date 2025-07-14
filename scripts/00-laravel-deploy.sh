#!/usr/bin/env bash
set -e

echo "Instalando dependencias con Composer..."
composer install --no-dev --optimize-autoloader --no-interaction

# Generar la clave solo si falta
if [ -z "$APP_KEY" ]; then
  echo "Generando APP_KEY..."
  export APP_KEY=$(php artisan key:generate --show)
  # Opcional: imprimirla para que la copies al dashboard
  echo "APP_KEY generada: $APP_KEY"
fi

# Archivo bandera para migrar solo una vez
FLAG="/var/www/html/storage/app/migrated.txt"

if [ ! -f "$FLAG" ]; then
  echo "Ejecutando migraciones..."
  php artisan migrate --force
  touch "$FLAG"
else
  echo "Migraciones ya ejecutadas, saltando..."
fi

echo "Cacheando configuración..."
php artisan config:cache
php artisan route:cache