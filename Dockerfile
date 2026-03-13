# Stage 1: Build stage
FROM php:8.2-fpm-alpine AS builder

# Install system dependencies
RUN apk add --no-cache \
    curl \
    git \
    zip \
    unzip \
    sqlite \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    bcmath \
    ctype \
    fileinfo \
    json \
    mbstring \
    tokenizer \
    xml

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy package files first for dependency caching
COPY package.json package-lock.json ./
COPY composer.json composer.lock ./

# Install Node dependencies
RUN npm ci

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build assets
RUN npm run build

# Generate Laravel key (optional, can be set via ENV)
RUN cp .env.example .env || true
RUN php artisan key:generate --force || true

# Stage 2: Runtime stage
FROM php:8.2-fpm-alpine

# Install runtime dependencies
RUN apk add --no-cache \
    curl \
    sqlite \
    nginx \
    supervisor

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    bcmath \
    ctype \
    fileinfo \
    json \
    mbstring \
    tokenizer \
    xml

# Set working directory
WORKDIR /app

# Copy application from builder
COPY --from=builder /app /app

# Create necessary directories with proper permissions
RUN mkdir -p /app/storage/framework/{cache,sessions,views} \
    && mkdir -p /app/storage/logs \
    && mkdir -p /app/bootstrap/cache \
    && chown -R www-data:www-data /app \
    && chmod -R 755 /app/storage \
    && chmod -R 755 /app/bootstrap/cache

# Copy nginx configuration
COPY nginx.conf /etc/nginx/http.d/default.conf

# Copy supervisor configuration
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port
EXPOSE 80

# Set environment
ENV APP_ENV=production

# Start supervisor to manage PHP-FPM and Nginx
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
