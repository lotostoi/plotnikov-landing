#!/bin/sh
set -e

cd /var/www/html

# Ensure storage directories exist with correct permissions
mkdir -p storage/app/public \
         storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs \
         bootstrap/cache

chmod -R 775 storage bootstrap/cache 2>/dev/null || true

if [ ! -f vendor/autoload.php ]; then
    echo "[entrypoint] Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

echo "[entrypoint] Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Named volume storage_data часто root:root; artisan выше тоже root — иначе www-data не пишет в views (tempnam / Blade → 500).
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

echo "[entrypoint] Starting php-fpm..."
exec "$@"
