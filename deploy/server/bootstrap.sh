#!/usr/bin/env bash

set -euo pipefail

APP_DIR="${APP_DIR:-/var/www/plotnikov-landing}"
REPO_SSH="${REPO_SSH:-git@github.com:lotostoi/plotnikov-landing.git}"
BRANCH="${BRANCH:-main}"

echo "[bootstrap] installing packages"
sudo apt update
sudo apt install -y git docker.io docker-compose-plugin nginx certbot python3-certbot-nginx

echo "[bootstrap] preparing app directory"
sudo mkdir -p "${APP_DIR}"
sudo chown -R "${USER}:${USER}" "${APP_DIR}"

if [ ! -d "${APP_DIR}/.git" ]; then
  echo "[bootstrap] cloning repository"
  git clone "${REPO_SSH}" "${APP_DIR}"
fi

cd "${APP_DIR}"
git fetch --all --prune
git checkout "${BRANCH}"
git pull origin "${BRANCH}"

if [ ! -f ".env" ]; then
  cp .env.production.example .env
  echo "[bootstrap] .env created from template, fill APP_KEY and domain values"
fi

echo "[bootstrap] generating app key if empty"
if ! grep -Eq "^APP_KEY=base64:" .env; then
  docker compose run --rm app php artisan key:generate
fi

echo "[bootstrap] first start"
docker compose up -d --build
docker compose exec -T app php artisan migrate --force

echo "[bootstrap] done"
