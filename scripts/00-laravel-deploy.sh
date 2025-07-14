#!/usr/bin/env bash
set -e

echo "Instalando dependencias con Composer..."
composer install --no-dev --optimize-autoloader --no-interaction

# Generar la clave solo si falta
if [ -z "$APP_KEY" ]; then
  echo "Generando APP_KEY..."
  export APP_KEY=$(php artisan key:generate --show)
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

echo "Limpiando y cacheando configuración..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Esperando a que PHP-FPM abra el socket..."
timeout 30 bash -c 'while [ ! -S /var/run/php-fpm.sock ]; do sleep 1; done'
echo "Socket php-fpm.sock encontrado ✅"