# Руководство по развёртыванию на продакшн

## Содержание

1. [Архитектура проекта](#архитектура)
2. [Первый деплой на сервер](#первый-деплой)
3. [Автодеплой через GitHub Actions](#автодеплой)
4. [Команды в Docker — шпаргалка](#команды-docker)
5. [Заполнение БД сидерами](#сидеры)
6. [Просмотр логов](#логи)
7. [Устранение типичных проблем](#проблемы)

---

## Архитектура

```
GitHub (main) ──push──► GitHub Actions ──SSH──► VPS
                                                  │
                                          scripts/deploy.sh
                                                  │
                                    docker compose up --build
                                                  │
                              ┌───────────────────┼──────────────────┐
                              │                   │                  │
                           db (MySQL 8)       app (PHP 8.4)     nginx (1.27)
                           port: 3306         port: 9000        port: 18080→8080
                           volume: db_data    volume: storage_data
```

**Данные не теряются** при пересборке: БД в томе `db_data`, загруженные файлы в `storage_data`.

---

## Первый деплой

### 1. Клонировать репозиторий на сервере

```bash
git clone git@github.com:lotostoi/plotnikov-landing.git /var/www/plotnikov-landing
cd /var/www/plotnikov-landing
```

### 2. Создать `.env`

```bash
cp .env.production.example .env
nano .env
```

Обязательно заполнить:

```env
APP_URL=https://ВАШ_ДОМЕН.ru

# Генерируй командой: php artisan key:generate --show (или после первого запуска)
APP_KEY=

DB_DATABASE=plotnikov_landing
DB_USERNAME=app
DB_PASSWORD=     # openssl rand -hex 16
DB_ROOT_PASSWORD=# openssl rand -hex 16

LOGS_TOKEN=      # openssl rand -hex 32
```

Генерация паролей прямо на сервере:
```bash
openssl rand -hex 16   # для DB_PASSWORD и DB_ROOT_PASSWORD
openssl rand -hex 32   # для LOGS_TOKEN
```

### 3. Сгенерировать APP_KEY

```bash
docker compose run --rm app php artisan key:generate --show
```

Скопировать вывод `base64:...` в `.env` → `APP_KEY=`.

### 4. Запустить деплой

```bash
./scripts/deploy.sh
```

Скрипт автоматически:
- Подтягивает код из `origin/main`
- Собирает Docker-образы
- Ждёт готовности MySQL
- Запускает все миграции
- Кэширует конфиг, роуты, вьюхи

### 5. Заполнить базу данных дефолтными данными

```bash
docker compose exec -T app php artisan db:seed
```

### 6. Создать администратора

```bash
docker compose exec app php artisan make:filament-user
```

Введи имя, email, пароль.

### 7. Создать символическую ссылку для storage

```bash
docker compose exec -T app php artisan storage:link --force
```

### 8. Проверить что всё работает

```bash
curl -s -o /dev/null -w "%{http_code}" https://ВАШ_ДОМЕН.ru
# Должно вернуть: 200
```

---

## Автодеплой

Workflow `.github/workflows/deploy.yml` уже настроен — триггерится при пуше в `main`.

### Добавить секреты в GitHub

`https://github.com/lotostoi/plotnikov-landing` → **Settings → Secrets and variables → Actions → New repository secret**

| Секрет | Значение | Пример |
|--------|----------|--------|
| `VPS_HOST` | IP или домен сервера | `1.2.3.4` |
| `VPS_USER` | Пользователь SSH | `ubuntu` |
| `VPS_SSH_KEY` | Приватный SSH-ключ (весь текст) | `-----BEGIN...-----END-----` |
| `VPS_PORT` | Порт SSH | `22` |
| `VPS_APP_DIR` | Путь к проекту | `/var/www/plotnikov-landing` |

### Создать SSH-ключ для деплоя (если нет)

На своей машине:
```bash
ssh-keygen -t ed25519 -C "github-deploy" -f ~/.ssh/github_deploy
# Добавить публичный ключ на сервер:
ssh-copy-id -i ~/.ssh/github_deploy.pub user@your-server
# Скопировать приватный ключ в секрет VPS_SSH_KEY:
cat ~/.ssh/github_deploy
```

После добавления секретов — **каждый `git push main` деплоится автоматически**.

---

## Команды Docker — шпаргалка

Все команды выполняются из `/var/www/plotnikov-landing` (где `docker-compose.yml`).

### Статус и мониторинг

```bash
# Статус контейнеров
docker compose ps

# Логи PHP (последние 100 строк)
docker compose logs --tail=100 app

# Логи nginx
docker compose logs --tail=50 nginx

# Следить за логами в реальном времени
docker compose logs -f app

# Логи Laravel (laravel.log)
docker compose exec -T app tail -n 200 storage/logs/laravel.log

# Следить за laravel.log в реальном времени
docker compose exec app tail -f storage/logs/laravel.log
```

### Управление контейнерами

```bash
# Перезапустить PHP (после изменения кода вручную)
docker compose restart app

# Перезапустить nginx (после изменения nginx.conf)
docker compose restart nginx

# Полный пересбор (как при деплое)
docker compose up -d --build --remove-orphans

# Остановить всё
docker compose down

# Остановить и удалить тома (ВНИМАНИЕ: удалит БД!)
docker compose down -v
```

### Artisan внутри контейнера

```bash
# Миграции
docker compose exec -T app php artisan migrate --force

# Откат последней миграции
docker compose exec -T app php artisan migrate:rollback

# Статус миграций
docker compose exec -T app php artisan migrate:status

# Сбросить БД и прогнать всё заново (ТОЛЬКО НА ЛОКАЛИ!)
docker compose exec -T app php artisan migrate:fresh --seed

# Заполнить БД сидерами (без сброса)
docker compose exec -T app php artisan db:seed

# Заполнить конкретным сидером
docker compose exec -T app php artisan db:seed --class=LandingContentSeeder
docker compose exec -T app php artisan db:seed --class=LandingBlocksSeeder

# Кэш
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache
docker compose exec -T app php artisan config:clear
docker compose exec -T app php artisan cache:clear

# Создать admin-пользователя
docker compose exec app php artisan make:filament-user

# Интерактивная консоль (tinker)
docker compose exec app php artisan tinker

# Войти в bash контейнера
docker compose exec app sh
```

### MySQL

```bash
# Войти в MySQL-консоль
docker compose exec db mysql -u app -p plotnikov_landing

# Войти как root
docker compose exec db mysql -uroot -p

# Дамп базы
docker compose exec -T db mysqldump -u app -pПАРОЛЬ plotnikov_landing > backup_$(date +%Y%m%d).sql

# Восстановить из дампа
docker compose exec -i db mysql -u app -pПАРОЛЬ plotnikov_landing < backup.sql
```

---

## Сидеры

Сидеры заполняют БД дефолтными данными. Безопасно запускать повторно — используют `updateOrCreate`.

### Что заполняют

| Сидер | Данные |
|-------|--------|
| `LandingContentSeeder` | Запись в `landing_page_contents`: SEO, персона, цены, настройки |
| `LandingBlocksSeeder` | Все блоки лендинга: заголовок, герой, обо мне, услуги, отзывы, FAQ, контакты, футер |

### Запуск всех сидеров

```bash
docker compose exec -T app php artisan db:seed
```

### Запуск конкретного сидера

```bash
# Только контент страницы (SEO, персона)
docker compose exec -T app php artisan db:seed --class=LandingContentSeeder

# Только блоки лендинга (секции)
docker compose exec -T app php artisan db:seed --class=LandingBlocksSeeder
```

### Полный сброс и пересев (ТОЛЬКО НА ЛОКАЛИ)

```bash
docker compose exec -T app php artisan migrate:fresh --seed
```

---

## Логи

### Вариант 1 — Filament (удобно, требует работающей БД)

```
https://ВАШ_ДОМЕН.ru/admin
```
Раздел **Система → Логи** — последние 500 строк с подсветкой ошибок, кнопка очистки.

### Вариант 2 — Аварийный URL (без БД, всегда работает)

```
https://ВАШ_ДОМЕН.ru/logs?token=ВАШ_LOGS_TOKEN
```

`LOGS_TOKEN` задаётся в `.env`. Страница работает даже если приложение падает с 500.

### Вариант 3 — Прямо на сервере

```bash
# Последние 200 строк
docker compose exec -T app tail -n 200 storage/logs/laravel.log

# В реальном времени
docker compose exec app tail -f storage/logs/laravel.log

# Только ошибки
docker compose exec -T app grep "ERROR\|CRITICAL" storage/logs/laravel.log | tail -50

# Очистить лог
docker compose exec -T app sh -c "> storage/logs/laravel.log"
```

---

## Проблемы

### 502 Bad Gateway

Nginx не может достучаться до PHP. Проверить:
```bash
docker compose ps              # app должен быть Up
docker compose restart nginx   # пересоздать соединение после рестарта app
docker compose logs --tail=20 app
```

### 500 Internal Server Error

Смотреть `laravel.log`:
```bash
docker compose exec -T app tail -n 50 storage/logs/laravel.log
```

### Миграции не проходят

```bash
docker compose exec -T app php artisan migrate:status
docker compose exec -T app php artisan migrate --force
```

### Стили/JS не грузятся

Проверить `APP_URL` в `.env` — должен совпадать с реальным доменом и протоколом:
```bash
grep APP_URL .env
# Должно быть: APP_URL=https://ВАШ_ДОМЕН.ru
```
После изменения — пересоздать контейнер:
```bash
docker compose up -d --force-recreate app
docker compose restart nginx
```

### MySQL readonly / не стартует

```bash
docker compose logs db
docker compose restart db
# Если том повреждён (только если не жалко данные):
docker compose down -v && docker compose up -d --build
```
