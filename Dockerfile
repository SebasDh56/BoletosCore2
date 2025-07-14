FROM php:8.2-fpm

# Instala dependencias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia los archivos del proyecto (incluyendo composer.json)
COPY . /var/www

# Instala las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Configura permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Ejecuta migraciones y seeder, luego inicia el servidor
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT