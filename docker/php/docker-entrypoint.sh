#!/bin/sh
set -e

cd /var/www/html || exit 1

# ---------------------------------------------------------------------------
# 1. Ensure all writable Laravel directories exist (matters on first boot
#    when named volumes are empty).
# ---------------------------------------------------------------------------
mkdir -p \
  storage/app/public \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache

# ---------------------------------------------------------------------------
# 2. Create the public/storage symlink so uploaded files are web-accessible.
#    Must run as root because public/ is owned by root in the image.
#    Nginx serves /storage/* directly via a volume alias anyway.
# ---------------------------------------------------------------------------
php artisan storage:link --no-interaction --force 2>/dev/null || true

# ---------------------------------------------------------------------------
# 3. Warm production caches.
#    Environment variables are injected by docker-compose (env_file / environment),
#    so no .env file exists inside the container — check APP_KEY instead.
# ---------------------------------------------------------------------------
if [ -n "$APP_KEY" ]; then
  su -s /bin/sh www-data -c "php artisan config:cache  --no-ansi" 2>/dev/null || true
  su -s /bin/sh www-data -c "php artisan route:cache   --no-ansi" 2>/dev/null || true
  su -s /bin/sh www-data -c "php artisan view:cache    --no-ansi" 2>/dev/null || true
  su -s /bin/sh www-data -c "php artisan event:cache   --no-ansi" 2>/dev/null || true
fi

exec docker-php-entrypoint "$@"
