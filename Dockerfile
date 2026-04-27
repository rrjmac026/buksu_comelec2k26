# =============================================================================
# Stage 1 — Vite production build (Node is not present in the runtime image)
# =============================================================================
FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci

# Full app tree (see .dockerignore); required by laravel-vite-plugin / Blade entrypoints
COPY . .

RUN npm run build

# =============================================================================
# Stage 2 — PHP-FPM (Laravel application)
# =============================================================================
FROM php:8.4-fpm-bookworm AS app

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    git \
    unzip \
    libicu-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache \
        curl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get purge -y --auto-remove $PHPIZE_DEPS \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-production.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html

COPY composer.json composer.lock ./
COPY . .

COPY --from=frontend /app/public/build ./public/build

ENV COMPOSER_MEMORY_LIMIT=-1

RUN composer install \
        --no-dev \
        --no-interaction \
        --prefer-dist \
        --optimize-autoloader \
        --no-scripts \
        --no-ansi \
    && composer dump-autoload --optimize --classmap-authoritative \
    && rm -rf /root/.composer/cache

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint-app.sh
RUN chmod +x /usr/local/bin/docker-entrypoint-app.sh

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

ENTRYPOINT ["/usr/local/bin/docker-entrypoint-app.sh"]
CMD ["php-fpm"]

# =============================================================================
# Stage 3 — Nginx (static files + FastCGI to `app:9000`)
# =============================================================================
FROM nginx:1.27-alpine AS nginx

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=app /var/www/html/public /var/www/html/public

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
