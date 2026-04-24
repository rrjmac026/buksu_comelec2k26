#!/bin/sh
set -e

cd /var/www/html || exit 1

# Writable paths for Laravel (works with empty named volumes on first run)
mkdir -p \
  storage/app/public \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache

# Production caches (require valid .env inside the container, including APP_KEY)
if [ -f .env ]; then
  su -s /bin/sh www-data -c "php artisan config:cache" || true
  su -s /bin/sh www-data -c "php artisan route:cache" || true
  su -s /bin/sh www-data -c "php artisan view:cache" || true
  su -s /bin/sh www-data -c "php artisan event:cache" 2>/dev/null || true
fi

exec docker-php-entrypoint "$@"
