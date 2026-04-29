#!/usr/bin/env bash

set -euo pipefail

APP_DIR="${APP_DIR:-/var/www/plotnikov-landing}"
BRANCH="${BRANCH:-main}"

echo "[deploy] app dir: ${APP_DIR}"
cd "${APP_DIR}"

# Загружаем переменные из .env (нужны DB_ROOT_PASSWORD для проверки MySQL).
if [ -f .env ]; then
    set -a
    # shellcheck disable=SC1091
    source .env
    set +a
fi

echo "[deploy] fetching branch ${BRANCH}"
git fetch --all --prune
git reset --hard "origin/${BRANCH}"

echo "[deploy] build & start containers"
docker compose up -d --build --remove-orphans

echo "[deploy] waiting for MySQL to be ready..."
until docker compose exec -T db mysqladmin ping -h localhost -uroot -p"${DB_ROOT_PASSWORD:-}" --silent 2>/dev/null; do
    echo "[deploy]   MySQL not ready, retrying in 3s..."
    sleep 3
done
echo "[deploy] MySQL is ready."

echo "[deploy] running migrations"
docker compose exec -T app php artisan migrate --force

echo "[deploy] caching config / routes / views"
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache
docker compose exec -T app php artisan event:cache

echo "[deploy] storage link"
docker compose exec -T app php artisan storage:link --force

echo "[deploy] done ✓"
