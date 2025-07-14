FROM richarvey/nginx-php-fpm:1.7.2

# Instala dependencias de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Copia todos los archivos del proyecto, incluyendo vendor/ pregenerado
COPY . /var/www/html

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root (aunque lo saltamos)
ENV COMPOSER_ALLOW_SUPERUSER 1

# Configura permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Genera y muestra la APP_KEY en los logs
RUN php /var/www/html/artisan key:generate --show

# Ejecuta migraciones y seeder antes de iniciar
RUN php /var/www/html/artisan migrate --force
RUN php /var/www/html/artisan db:seed --force

# Usa el script de inicio predeterminado
CMD ["/start.sh"]