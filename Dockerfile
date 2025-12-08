# PHP / php-fpm image
FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev build-essential \
    libicu-dev default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Instalar composer (desde la imagen oficial de composer)
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Crear usuario www-data con UID 1000 (coincide con muchos mounts)
RUN useradd -u 1000 -m www

WORKDIR /var/www

# Copiar composer.json primero para cachear composer install
COPY composer.json composer.lock /var/www/

RUN composer install --no-dev --no-autoloader --no-scripts --prefer-dist --no-interaction || true

# Copiar el resto del proyecto
COPY . /var/www

# Instalar dependencias PHP definitivas y generar autoload
RUN composer install --no-interaction --prefer-dist \
    && composer dump-autoload --optimize

# Ajustes de permisos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Exponer el puerto del php-fpm (internal)
EXPOSE 9000

# Usar php-fpm con UID 1000 si es necesario
CMD ["php-fpm"]
