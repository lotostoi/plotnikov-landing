# Автодеплой через GitHub Actions (пошагово)

Репозиторий уже содержит workflow [`.github/workflows/deploy.yml`](../../.github/workflows/deploy.yml): при **push в ветку `main`** (и при ручном **Run workflow**) GitHub подключается по SSH к VPS и выполняет [`scripts/deploy.sh`](../../scripts/deploy.sh) (git pull, `docker compose up --build`, миграции, кэши).

Ниже — что сделать **на сервере** и **в GitHub**, чтобы это заработало с нуля.

---

## Важно: два разных SSH-ключа

Путаница здесь самая частая причина «не деплоится».

| Ключ | Где приватный | Где публичный | Зачем |
|------|---------------|---------------|--------|
| **A. GitHub Actions → VPS** | Секрет `VPS_SSH_KEY` в GitHub | `~/.ssh/authorized_keys` пользователя деплоя на сервере | Раннер GitHub заходит по SSH и запускает `deploy.sh` |
| **B. VPS → GitHub (git)** | На сервере, например `~/.ssh/github_repo` | **Deploy keys** репозитория (только чтение) или SSH-ключ вашего аккаунта | Команда `git fetch` на сервере тянет код с GitHub |

Без ключа **B** скрипт на сервере упадёт на `git fetch` с ошибкой доступа к репозиторию, даже если Actions успешно зашёл по SSH.

---

## Часть 1. Сервер (VPS)

### 1.1. Пользователь и Docker

Рекомендуется отдельный пользователь (например `deploy` или ваш `ubuntu`), под которым лежит проект.

```bash
# пользователь в группе docker — без sudo для compose
sudo usermod -aG docker "$USER"
# перелогиниться или: newgrp docker
docker ps
```

### 1.2. Клон репозитория и каталог

Путь должен **совпасть** с секретом `VPS_APP_DIR` (часто `/var/www/plotnikov-landing`).

```bash
sudo mkdir -p /var/www
sudo chown "$USER:$USER" /var/www
cd /var/www
git clone git@github.com:ВАШ_ОРГ/ВАШ_РЕПО.git plotnikov-landing
cd plotnikov-landing
```

Если `git clone` по SSH не проходит — сначала настройте ключ **B** (шаг 1.4).

### 1.3. Первый запуск: `.env` и деплой

```bash
cp .env.production.example .env
nano .env   # APP_URL, APP_KEY, пароли БД, LOGS_TOKEN — по .env.production.example
./scripts/deploy.sh
```

Один раз: сиды, админ Filament, внешний nginx — по [руководству по продакшену](../../docs/deploy/production-guide.md).

### 1.4. Ключ **B**: сервер → GitHub (чтение репозитория)

На **сервере**:

```bash
ssh-keygen -t ed25519 -C "vps-git-readonly" -f ~/.ssh/github_plotnikov_deploy -N ""
cat ~/.ssh/github_plotnikov_deploy.pub
```

В GitHub: репозиторий → **Settings → Deploy keys → Add deploy key** — вставить **публичный** ключ, включить **Allow read only access**.

Настроить git использовать этот ключ для `github.com`:

```bash
nano ~/.ssh/config
```

Пример:

```
Host github.com
  HostName github.com
  User git
  IdentityFile ~/.ssh/github_plotnikov_deploy
  IdentitiesOnly yes
```

Проверка:

```bash
ssh -T git@github.com
cd /var/www/plotnikov-landing && git fetch origin && git status
```

### 1.5. Ключ **A**: GitHub Actions → VPS

На **вашей машине** (не на сервере), отдельная пара только для CI:

```bash
ssh-keygen -t ed25519 -C "github-actions-deploy" -f ~/.ssh/gh_actions_deploy -N ""
```

На **сервере** добавить **публичный** ключ в `authorized_keys` того пользователя, от имени которого пойдёт деплой:

```bash
mkdir -p ~/.ssh
chmod 700 ~/.ssh
echo 'СОДЕРЖИМОЕ gh_actions_deploy.pub ОДНОЙ СТРОКОЙ' >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

Проверка с локальной машины:

```bash
ssh -i ~/.ssh/gh_actions_deploy -p 22 USER@VPS_IP "echo ok"
```

**Приватный** ключ `gh_actions_deploy` (весь файл от `BEGIN` до `END`) пойдёт в секрет `VPS_SSH_KEY` (часть 2).

### 1.6. Права на `deploy.sh`

```bash
chmod +x /var/www/plotnikov-landing/scripts/deploy.sh
```

---

## Часть 2. Репозиторий GitHub

### 2.1. Секреты Actions

**Repository → Settings → Secrets and variables → Actions → New repository secret**

| Секрет | Обязателен | Описание |
|--------|------------|----------|
| `VPS_HOST` | да | IP или домен SSH |
| `VPS_USER` | да | пользователь Linux на VPS |
| `VPS_SSH_KEY` | да | приватный ключ **A** (целиком) |
| `VPS_APP_DIR` | да | абсолютный путь к клону, например `/var/www/plotnikov-landing` |
| `VPS_PORT` | нет | SSH-порт; если не задан — в workflow подставляется `22` |
| `VPS_SSH_PASSPHRASE` | нет | только если у ключа **A** есть парольная фраза |

Имена секретов должны **точно** совпадать с таблицей (workflow читает именно их).

### 2.2. Ветка `main`

Автодеплой срабатывает только на **push в `main`**. Другие ветки workflow не запускают (если не менять `deploy.yml`).

### 2.3. Проверка

1. **Actions** → последний запуск workflow **Deploy to VPS** — зелёный.
2. Либо **Actions → Deploy to VPS → Run workflow** (ручной запуск).
3. На сервере после деплоя: `cd "$VPS_APP_DIR" && git log -1 --oneline` совпадает с последним коммитом в `main`.

---

## Часть 3. Внешний nginx и SSL

Workflow **не** настраивает системный nginx: на VPS должен быть прокси на порт приложения (`APP_PORT` в `.env`, по умолчанию **18080**), как в [примере конфига](../../deploy/nginx/plotnikov-landing.conf). SSL — certbot или панель хостинга — вне этого workflow.

---

## Типичные ошибки

| Симптом | Что проверить |
|---------|----------------|
| SSH из Actions: Permission denied | Публичный ключ **A** в `authorized_keys`, верный `VPS_USER` / `VPS_HOST` / `VPS_PORT` |
| На шаге `git fetch`: Host key verification failed | На сервере один раз: `ssh -T git@github.com` под пользователем деплоя |
| `git fetch`: Permission denied (publickey) | Deploy key **B** или `~/.ssh/config` для `github.com` |
| `docker: permission denied` | Пользователь в группе `docker`, перелогин |
| Таймаут в GitHub Actions | Первый `docker compose build` долгий — в workflow задан `command_timeout`; при очень слабом VPS можно увеличить в `deploy.yml` |
| Пустой `cd` / неверный каталог | Секрет `VPS_APP_DIR` без опечаток, совпадает с реальным путём клонирования |

---

## Связанные файлы

- [`.github/workflows/deploy.yml`](../../.github/workflows/deploy.yml)
- [`scripts/deploy.sh`](../../scripts/deploy.sh)
- [`docker-compose.yml`](../../docker-compose.yml)
- Кратко в [docs/deploy/production-guide.md](../../docs/deploy/production-guide.md) (раздел «Автодеплой»)
