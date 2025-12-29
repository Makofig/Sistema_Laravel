#!/bin/sh
set -e

INIT_FILE="/var/www/.initialized"

echo "🚀 Starting Laravel container..."

# Esperar MySQL
echo "⏳ Waiting for MySQL TCP..."
until nc -z mysql 3306; do
    sleep 2
done
echo "✅ MySQL port is open"

if [ ! -f "$INIT_FILE" ]; then
    echo "🆕 First container run detected"
    
    # Composer
    if [ ! -d "vendor" ]; then
        echo "📦 Installing composer dependencies..."
        composer install --no-interaction --prefer-dist
    fi
    
    # APP KEY
    if ! grep -q "APP_KEY=base64" .env; then
        echo "🔑 Generating APP_KEY..."
        php artisan key:generate
    fi
    
    # Migrations + seed SOLO primera vez
    echo "🗄 Running migrations & seed..."
    php artisan migrate --force --seed
    
    touch "$INIT_FILE"
    echo "✅ Initialization completed"
else
    echo "♻️ Existing volume detected, skipping init"
fi

php artisan optimize:clear

exec php-fpm
