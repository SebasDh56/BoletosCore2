FROM richarvey/nginx-php-fpm:latest

# Instala dependencias de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia todos los archivos del proyecto, incluyendo vendor/ pregenerado
COPY . /var/www/html

# Configura permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Genera y muestra la APP_KEY en los logs
RUN php /var/www/html/artisan key:generate --show

# Ejecuta migraciones y seeder al iniciar (usando un script)
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
CMD ["/entrypoint.sh"]