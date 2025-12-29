# PHP / php-fpm image
FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev build-essential \
    libicu-dev default-mysql-client netcat-openbsd \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Instalar composer (desde la imagen oficial de composer)
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Crear usuario www-data con UID 1000 (coincide con muchos mounts)
RUN useradd -u 1000 -m www

WORKDIR /var/www

# Copiar archivos de la aplicación al contenedor
COPY . .

# Ajustes de permisos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Instalar dependencias de PHP usando Composer
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Exponer el puerto del php-fpm (internal)
EXPOSE 9000

# Definir el entrypoint
ENTRYPOINT ["entrypoint.sh"]