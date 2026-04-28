#!/bin/sh
set -e

cd /var/www/html

if [ ! -f vendor/autoload.php ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

exec "$@"
