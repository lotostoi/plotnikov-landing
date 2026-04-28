#!/bin/sh
set -e

cd /var/www/html

mkdir -p storage/app/public \
         storage/database \
         storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs \
         bootstrap/cache

# SQLite по умолчанию в storage (том); один раз копируем со старого пути, если там ещё лежит база.
if [ ! -f storage/database/database.sqlite ]; then
    if [ -r database/database.sqlite ]; then
        echo "[entrypoint] copy database/database.sqlite → storage/database/database.sqlite"
        cp -a database/database.sqlite storage/database/database.sqlite
    else
        touch storage/database/database.sqlite
    fi
fi

chmod -R u+rwX,g+rwX,o+rX storage bootstrap/cache 2>/dev/null || true

# Владелец — php-fpm (www-data, uid 82). Без этого tempnam() падает в /tmp → Notice → Laravel 500.
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null \
  || chown -R 82:82 storage bootstrap/cache 2>/dev/null \
  || echo "[entrypoint] WARN: chown www-data failed (volume/NFS?) — см. chmod fallback ниже"

# Если chown невозможен, даём запись в каталоги компиляции Blade (одиночный VPS).
if ! su -s /bin/sh www-data -c "touch /var/www/html/storage/framework/views/.wprobe 2>/dev/null && rm -f /var/www/html/storage/framework/views/.wprobe"; then
  echo "[entrypoint] WARN: www-data не пишет в views — chmod 777 на framework dirs"
  chmod 777 storage/framework/views storage/framework/cache/data storage/framework/sessions 2>/dev/null || true
  chmod 777 bootstrap/cache 2>/dev/null || true
fi

if [ ! -f vendor/autoload.php ]; then
    echo "[entrypoint] Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || chown -R 82:82 storage bootstrap/cache 2>/dev/null || true
fi

echo "[entrypoint] Caching config, routes, views (as www-data)..."
if su -s /bin/sh www-data -c "cd /var/www/html && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan event:cache"; then
  :
else
  echo "[entrypoint] WARN: artisan cache as www-data failed, retry as root + chown"
  set +e
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan event:cache
  set -e
  chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || chown -R 82:82 storage bootstrap/cache 2>/dev/null || true
fi

echo "[entrypoint] Starting php-fpm..."
exec "$@"
