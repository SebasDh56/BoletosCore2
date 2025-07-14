FROM richarvey/nginx-php-fpm:latest

# Instala dependencias de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia todos los archivos del proyecto, incluyendo vendor/ pregenerado
COPY . /var/www

# Configura permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Genera y muestra la APP_KEY en los logs
RUN php artisan key:generate --show

# Ejecuta migraciones, seeder y luego inicia el servidor
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT