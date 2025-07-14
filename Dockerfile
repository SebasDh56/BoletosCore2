FROM php:8.2-fpm

# Instala dependencias necesarias para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia todo el proyecto (incluyendo vendor/)
COPY . /var/www

# Genera la APP_KEY y la muestra en los logs
RUN php artisan key:generate --show

# Configura permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Ejecuta migraciones, seeder y luego inicia el servidor
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT