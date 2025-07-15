<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# BoletosCore

¡Bienvenido al repositorio de **BoletosCore**, un sistema de gestión de boletos basado en Laravel! Este proyecto permite la administración de usuarios, cooperativas, personas y ventas, con un frontend estilizado y soporte para despliegue en Render.

## Sobre Laravel

Laravel es un framework de aplicaciones web con una sintaxis expresiva y elegante. Creemos que el desarrollo debe ser una experiencia agradable y creativa para ser verdaderamente satisfactoria. Laravel alivia las tareas comunes utilizadas en muchos proyectos web, como:

- [Motor de enrutamiento simple y rápido](https://laravel.com/docs/routing).
- [Contenedor poderoso de inyección de dependencias](https://laravel.com/docs/container).
- Múltiples backends para [sesión](https://laravel.com/docs/session) y [almacenamiento en caché](https://laravel.com/docs/cache).
- ORM de base de datos expresivo e intuitivo [Eloquent](https://laravel.com/docs/eloquent).
- Migraciones de esquema agnósticas a la base de datos [migraciones](https://laravel.com/docs/migrations).
- [Procesamiento robusto de trabajos en segundo plano](https://laravel.com/docs/queues).
- [Transmisión de eventos en tiempo real](https://laravel.com/docs/broadcasting).

Laravel es accesible, potente y proporciona las herramientas necesarias para aplicaciones grandes y robustas.

## Aprendiendo Laravel

Laravel tiene la documentación y biblioteca de tutoriales en video más extensa y completa de todos los frameworks de aplicaciones web modernos, lo que facilita comenzar con el framework.

También puedes probar el [Laravel Bootcamp](https://bootcamp.laravel.com), donde te guiarán para construir una aplicación moderna de Laravel desde cero.

Si no te gusta leer, [Laracasts](https://laracasts.com) puede ayudarte. Laracasts contiene miles de tutoriales en video sobre una gama de temas, incluyendo Laravel, PHP moderno, pruebas unitarias y JavaScript. Mejora tus habilidades explorando nuestra biblioteca de videos completa.

## Patrocinadores de Laravel

Queremos extender nuestro agradecimiento a los siguientes patrocinadores por financiar el desarrollo de Laravel. Si estás interesado en convertirte en patrocinador, visita el programa [Laravel Partners](https://partners.laravel.com).

### Patrocinadores Premium

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Descripción del Proyecto

BoletosCore es una aplicación web desarrollada con Laravel 12.19.3 que ofrece funcionalidades para gestionar usuarios (solo para administradores), cooperativas, personas y ventas. Los clientes tienen acceso restringido a las secciones de "Personas" y "Ventas", mientras que los administradores pueden gestionar todo. El sistema utiliza una base de datos PostgreSQL y está optimizado para desplegarse en Render.

## Requisitos
- PHP 8.2 o superior
- Composer
- Node.js y NPM (para assets)
- PostgreSQL
- Docker (para despliegue en Render)

## Instalación

### 1. Clonar el Repositorio
```bash
git clone https://github.com/tu-usuario/boletoscore.git
cd boletoscore
```
2. Instalar Dependencias
Instala las dependencias de PHP:
bash

Contraer

Ajuste

Ejecutar

Copiar
composer install
Instala las dependencias de JavaScript (si usas Laravel Mix):
bash

Contraer

Ajuste

Ejecutar

Copiar
npm install
npm run dev
3. Configurar el Entorno
Copia el archivo .env.example a .env:
bash

Contraer

Ajuste

Ejecutar

Copiar
cp .env.example .env
Configura las variables de entorno en .env, incluyendo:
APP_KEY=
DB_CONNECTION=pgsql
DB_HOST=
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
Genera una clave de aplicación:
bash

Contraer

Ajuste

Ejecutar

Copiar
php artisan key:generate
4. Configurar la Base de Datos
Crea una base de datos PostgreSQL y actualiza las credenciales en .env.
Ejecuta las migraciones y seeds:
bash

Contraer

Ajuste

Ejecutar

Copiar
php artisan migrate --seed
5. Iniciar la Aplicación
Inicia el servidor local:
bash

Contraer

Ajuste

Ejecutar

Copiar
php artisan serve
Accede a http://localhost:8000 en tu navegador.
Estructura del Proyecto
app/: Contiene los modelos, controladores y servicios.
resources/views/: Plantillas Blade (e.g., app.blade.php).
routes/: Definición de rutas (e.g., web.php).
docker/: Configuraciones de Docker para Render.
scripts/: Scripts de implementación (e.g., 00-laravel-deploy.sh).
conf/nginx/: Configuración personalizada de Nginx (opcional).
Despliegue en Render
1. Preparar el Repositorio
Asegúrate de que los archivos Dockerfile, .dockerignore, y vendor/ (pregenerado) estén en el repositorio.
Edita .gitignore para no ignorar vendor/ (comenta o elimina la línea /vendor).
2. Configurar Docker
El Dockerfile usa la imagen richarvey/nginx-php-fpm:latest con las siguientes configuraciones:
dockerfile

Contraer

Ajuste

Copiar
FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
COPY scripts/00-laravel-deploy.sh /scripts/00-laravel-deploy.sh
RUN chmod +x /scripts/00-laravel-deploy.sh

CMD ["/start.sh"]
El script scripts/00-laravel-deploy.sh incluye:
bash

Contraer

Ajuste

Ejecutar

Copiar
#!/usr/bin/env bash
echo "Generating application key..."
php /var/www/html/artisan key:generate --force
echo "Caching config..."
php /var/www/html/artisan config:cache
echo "Caching routes..."
php /var/www/html/artisan route:cache
echo "Running migrations..."
php /var/www/html/artisan migrate --force
echo "Running seeds..."
php /var/www/html/artisan db:seed --force
3. Desplegar en Render
Conecta tu cuenta de GitHub a Render.
Crea un nuevo servicio web, selecciona el repositorio, y configura las variables de entorno:
APP_KEY=base64:tu-clave-generada
DB_CONNECTION=pgsql
DB_HOST=tu-host-postgres-render
DB_PORT=5432
DB_DATABASE=tu-base-datos
DB_USERNAME=tu-usuario
DB_PASSWORD=tu-contraseña
DB_SSLMODE=require
Haz un despliegue manual y verifica la URL proporcionada.
Uso
Clientes: Pueden acceder a "Personas" y "Ventas" tras iniciar sesión.
Administradores: Tienen acceso completo, incluyendo "Gestionar Usuarios" y "Cooperativas".
Inicia sesión con admin@boletoscore.com / password123 (o credenciales definidas en el seeder).
