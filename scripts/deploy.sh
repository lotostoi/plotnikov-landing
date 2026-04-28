#!/usr/bin/env bash

set -euo pipefail

APP_DIR="${APP_DIR:-/var/www/plotnikov-landing}"
BRANCH="${BRANCH:-main}"

echo "[deploy] app dir: ${APP_DIR}"
cd "${APP_DIR}"

echo "[deploy] fetching branch ${BRANCH}"
git fetch --all --prune
git reset --hard "origin/${BRANCH}"

echo "[deploy] building and starting containers"
docker compose up -d --build --remove-orphans

echo "[deploy] waiting for php-fpm to be ready..."
sleep 3

echo "[deploy] running artisan tasks"
docker compose exec -T app php artisan migrate --force
docker compose exec -T app php artisan storage:link --force

echo "[deploy] done"
