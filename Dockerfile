FROM php:8.2-fpm

# Instala dependencias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Copia archivos
COPY . /var/www
WORKDIR /var/www

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Configura permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Comando por defecto
CMD php artisan serve --host=0.0.0.0 --port=$PORT