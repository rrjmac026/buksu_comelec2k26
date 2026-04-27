# BUKSU COMELEC 2K26 — Docker Deployment Guide

> **Live URL:** http://comelec.buksu.edu.ph  
> **Server public IP:** 203.177.114.167  
> **Server internal IP:** 10.1.0.10  
> **SSH port:** 2210  
> **Target OS:** Ubuntu (Docker Engine 25+, Docker Compose v2)

---

## Step 0 — Connect to the Server

```bash
ssh -p 2210 <your-username>@203.177.114.167
```

---

## Step 1 — Install Docker (first time only)

Run this once on the Ubuntu server:

```bash
# Install Docker Engine
curl -fsSL https://get.docker.com | sh

# Allow your user to run docker without sudo
sudo usermod -aG docker $USER

# Log out and back in, then verify
docker --version
docker compose version
```

---

## Step 2 — Clone the Repository

```bash
sudo mkdir -p /srv/buksu_comelec2k26
sudo chown $USER:$USER /srv/buksu_comelec2k26

git clone <your-repo-url> /srv/buksu_comelec2k26
cd /srv/buksu_comelec2k26
```

---

## Step 3 — Set Up the Environment File

```bash
cp .env.example .env
nano .env
```

Fill in the following required values:

| Key | Value to set |
|-----|-------------|
| `APP_URL` | `http://comelec.buksu.edu.ph` |
| `DB_PASSWORD` | A strong random password (e.g. `openssl rand -base64 24`) |
| `DB_ROOT_PASSWORD` | A different strong random password |
| `APP_KEY` | Leave blank — generated in Step 5 |

Everything else is already configured for Docker (DB_HOST=mysql, REDIS_HOST=redis, etc.).

---

## Step 4 — Build and Start All Containers

```bash
cd /srv/buksu_comelec2k26
docker compose up -d --build
```

This will:
- Build the Vite frontend assets (Node.js stage)
- Build the PHP-FPM Laravel app image
- Build the Nginx image
- Start MySQL 8, Redis 7, Nginx, and PHP-FPM

Wait for all containers to show `Up`:

```bash
docker compose ps
```

---

## Step 5 — First-Time Laravel Setup

Run these commands **once** after the first build:

```bash
# Generate the application encryption key
docker compose exec app php artisan key:generate

# Restart so the new key is picked up by the config cache
docker compose restart app

# Run all database migrations
docker compose exec app php artisan migrate --force

# Create the public/storage symlink
docker compose exec app php artisan storage:link

# (Optional) Seed initial data
docker compose exec app php artisan db:seed --force

# Warm all Laravel caches
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
docker compose exec app php artisan event:cache
```

---

## Step 6 — Verify the Deployment

```bash
# All containers must be running
docker compose ps

# Check app logs for errors
docker compose logs app --tail=50

# Check nginx is serving correctly
curl -I http://203.177.114.167
curl -I http://comelec.buksu.edu.ph    # after DNS is pointed
```

Open in browser: **http://comelec.buksu.edu.ph**

---

## DNS Setup (if not already done)

Point the domain to the server's public IP. Ask your IT/DNS admin to add:

```
Type  : A
Name  : comelec
Value : 203.177.114.167
TTL   : 3600
```

This creates `comelec.buksu.edu.ph → 203.177.114.167`.

---

## Optional Services

### Enable queue worker (processes background jobs)

```bash
docker compose --profile queue up -d
```

### Enable Laravel scheduler (cron-like tasks)

```bash
docker compose --profile scheduler up -d
```

### Enable Adminer (visual database UI)

```bash
docker compose --profile adminer up -d
# Access at: http://203.177.114.167:8080
# Server: mysql | User: comelec | Password: <DB_PASSWORD>
```

### Enable all extras

```bash
docker compose --profile queue --profile scheduler --profile adminer up -d
```

---

## Safe Update — Future Deployments

Every time you push new code and want to update the live server:

```bash
# 1. Connect to server
ssh -p 2210 <your-username>@203.177.114.167
cd /srv/buksu_comelec2k26

# 2. Pull latest code
git pull origin main

# 3. Rebuild and restart (data volumes are preserved)
docker compose down
docker compose up -d --build

# 4. Run new migrations
docker compose exec app php artisan migrate --force

# 5. Clear old caches and re-warm
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan optimize
```

---

## Useful Commands

### View logs

```bash
docker compose logs -f              # all services
docker compose logs -f app          # PHP/Laravel only
docker compose logs -f nginx        # Nginx only
docker compose logs -f mysql        # MySQL only
```

### Open a shell inside the app container

```bash
docker compose exec app bash
```

### Run Artisan commands

```bash
docker compose exec app php artisan <command>

# Common examples:
docker compose exec app php artisan tinker
docker compose exec app php artisan cache:clear
docker compose exec app php artisan queue:failed
docker compose exec app php artisan queue:retry all
```

### Restart a container

```bash
docker compose restart app
docker compose restart nginx
```

### Connect to MySQL

```bash
docker compose exec mysql mysql -u comelec -p comelec2k26
```

### Stop everything

```bash
docker compose down
```

### Stop and delete all data (DESTRUCTIVE)

```bash
docker compose down -v    # ⚠️ This deletes the database!
```

---

## Backup & Restore

### Backup the database

```bash
docker compose exec mysql \
  mysqldump -uroot -p"${DB_ROOT_PASSWORD}" comelec2k26 \
  > /srv/backups/comelec2k26_$(date +%Y%m%d_%H%M%S).sql
```

### Restore from a dump

```bash
cat your_backup.sql | docker compose exec -T mysql \
  mysql -uroot -p"${DB_ROOT_PASSWORD}" comelec2k26
```

### Backup uploaded files (storage volume)

```bash
docker run --rm \
  -v buksu_comelec2k26_app_storage:/data \
  -v /srv/backups:/backup \
  alpine tar czf /backup/storage_$(date +%Y%m%d).tar.gz /data
```

---

## Troubleshooting

### Site shows 403 or blank page
```bash
docker compose logs nginx --tail=30
docker compose exec app php artisan storage:link
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### 500 Server Error
```bash
docker compose logs app --tail=50
docker compose exec app tail -100 storage/logs/laravel.log
```

### APP_KEY missing / "No application encryption key"
```bash
docker compose exec app php artisan key:generate
docker compose restart app
```

### Database connection refused
MySQL takes ~40 s on first boot. Check it's healthy:
```bash
docker compose ps mysql
# Wait until status shows "healthy", then:
docker compose exec app php artisan migrate --force
```

### Uploaded files not showing (storage 404)
The `app_storage` volume must be mounted in both `app` and `nginx` services (already done). Verify:
```bash
docker compose exec nginx ls /var/www/html/storage/app/public/
```

### Vite assets not loading (/build/ 404)
Vite builds during `docker compose build`. Force a clean rebuild:
```bash
docker compose down
docker compose up -d --build
```

### Container in restart loop
```bash
docker compose logs app --tail=20
# Most common: missing APP_KEY or wrong DB_PASSWORD in .env
```

---

## Architecture

```
Internet
    │
    ▼  203.177.114.167:80
    │  comelec.buksu.edu.ph
    │
┌───────────────────────────────────────────────────────────┐
│  nginx container  (port 80)                               │
│  ├── /build/*    → serves Vite-compiled assets (cached)   │
│  ├── /storage/*  → serves uploaded files from volume      │
│  └── *.php       → FastCGI → app:9000                     │
└─────────────────────────┬─────────────────────────────────┘
                          │ FastCGI (port 9000)
                          ▼
┌─────────────────────────────────────────────────────────┐
│  app container  (PHP 8.3-FPM + Laravel 12)              │
│  volumes:                                               │
│    app_storage        → /var/www/html/storage           │
│    app_bootstrap_cache→ /var/www/html/bootstrap/cache   │
└──────────────┬──────────────────────┬───────────────────┘
               │                      │
               ▼                      ▼
        mysql:3306               redis:6379
   (MySQL 8 · mysql_data)   (Redis 7 · redis_data)
```

---

## File Reference

| File | Purpose |
|------|---------|
| `Dockerfile` | Multi-stage build: Node (Vite) → PHP-FPM app → Nginx |
| `docker-compose.yml` | All services, volumes, networks, and profiles |
| `docker/nginx/default.conf` | Nginx: routes, FastCGI, storage alias, gzip |
| `docker/php/php.ini` | PHP production settings (memory, OPcache, upload size) |
| `docker/php/www.conf` | PHP-FPM pool: listens on `0.0.0.0:9000` |
| `docker/php/docker-entrypoint.sh` | Startup: permissions, storage:link, cache warm-up |
| `.dockerignore` | Excludes secrets / dev files from build context |
| `.env.example` | Production environment template |
| `DEPLOYMENT.md` | This file |
