# Деплой — Plotnikov Landing

## Архитектура

```
GitHub (main) → GitHub Actions → SSH → VPS → scripts/deploy.sh
```

- Пуш в ветку `main` автоматически запускает деплой.
- На сервере выполняется `scripts/deploy.sh` через SSH.

---

## Первоначальная настройка сервера (один раз)

### 1. Клонировать репозиторий

```bash
git clone git@github.com:lotostoi/plotnikov-landing.git /var/www/plotnikov-landing
cd /var/www/plotnikov-landing
```

### 2. Создать `.env` из шаблона

```bash
cp .env.production.example .env
```

Заполнить обязательные поля:

| Переменная | Описание |
|-----------|----------|
| `APP_KEY` | Генерируется командой ниже |
| `APP_URL` | Точный https-адрес сайта, например `https://plotnikov-al-psy.online` |
| `DB_DATABASE` | Имя БД, например `plotnikov_landing` |
| `DB_USERNAME` | Пользователь MySQL (не root), например `app` |
| `DB_PASSWORD` | Пароль для `DB_USERNAME` (сложный) |
| `DB_ROOT_PASSWORD` | Root-пароль MySQL (только для healthcheck) |
| `LOGS_TOKEN` | Случайный токен для `/logs?token=...` |

### 3. Запустить первый деплой вручную

```bash
cd /var/www/plotnikov-landing
./scripts/deploy.sh
```

Скрипт: соберёт образы, поднимет MySQL, дождётся готовности, запустит миграции.

### 4. Создать admin-пользователя Filament

```bash
docker compose exec -T app php artisan make:filament-user
```

---

## GitHub Actions — секреты

Зайти: `https://github.com/lotostoi/plotnikov-landing` → **Settings** → **Secrets and variables** → **Actions** → **New repository secret**

| Секрет | Значение |
|--------|----------|
| `VPS_HOST` | IP-адрес или домен сервера |
| `VPS_USER` | Пользователь SSH (например `ubuntu`, `lotos`) |
| `VPS_SSH_KEY` | Содержимое приватного ключа `~/.ssh/id_rsa` (скопировать полностью с `-----BEGIN-----` до `-----END-----`) |
| `VPS_PORT` | Порт SSH, обычно `22` |
| `VPS_APP_DIR` | Путь к проекту на сервере: `/var/www/plotnikov-landing` |

После добавления всех секретов — пуш в `main` задеплоит автоматически.

Полная пошаговая инструкция (сервер, deploy key для `git fetch`, секреты): [documentation/deploy/github-actions-autodeploy.md](../../documentation/deploy/github-actions-autodeploy.md).

### Генерация SSH-ключа (если нет)

На своей машине:

```bash
ssh-keygen -t ed25519 -C "github-actions-deploy"
# Скопировать публичный ключ на сервер:
ssh-copy-id -i ~/.ssh/id_ed25519.pub user@your-server
# Содержимое приватного ключа добавить в секрет VPS_SSH_KEY:
cat ~/.ssh/id_ed25519
```

---

## Ручной деплой (если что-то пошло не так)

```bash
ssh user@your-server
cd /var/www/plotnikov-landing
./scripts/deploy.sh
```

---

## Просмотр логов

### Вариант 1 — Filament (требует работающей БД)

Зайти в `/admin` → раздел **Система** → **Логи**.

### Вариант 2 — Аварийный URL (работает без БД)

```
https://your-site.com/logs?token=YOUR_LOGS_TOKEN
```

`LOGS_TOKEN` задаётся в `.env` на сервере. Страница читает `storage/logs/laravel.log` напрямую с диска — работает даже если приложение падает с 500.

### Вариант 3 — Прямо на сервере

```bash
cd /var/www/plotnikov-landing
docker compose exec -T app tail -n 200 storage/logs/laravel.log
# Или в реальном времени:
docker compose exec app tail -f storage/logs/laravel.log
```

---

## Команды на сервере

```bash
# Миграции
docker compose exec -T app php artisan migrate --force

# Сбросить кэш конфига
docker compose exec -T app php artisan config:clear

# Статус контейнеров
docker compose ps

# Перезапустить
docker compose restart app
```
