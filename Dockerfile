FROM php:8.2-fpm

# ── System dependencies ───────────────────────────────────────────────────────
RUN apt-get update && apt-get install -y \
        git \
        curl \
        nginx \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        libpq-dev \
        zip \
        unzip \
        nodejs \
        npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ── PHP extensions ────────────────────────────────────────────────────────────
# Configure GD with JPEG + FreeType before installing
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache

# ── OPcache (production settings) ────────────────────────────────────────────
RUN { \
        echo 'opcache.enable=1'; \
        echo 'opcache.validate_timestamps=0'; \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=16'; \
        echo 'opcache.max_accelerated_files=20000'; \
        echo 'opcache.fast_shutdown=1'; \
    } > /usr/local/etc/php/conf.d/opcache-production.ini

# ── Composer ──────────────────────────────────────────────────────────────────
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ── Application ───────────────────────────────────────────────────────────────
WORKDIR /var/www/html

# .env is excluded by .dockerignore — all config comes from Render env vars
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm ci && npm run build

# ── Nginx ─────────────────────────────────────────────────────────────────────
RUN cp nginx.conf /etc/nginx/sites-available/default \
    && ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Route nginx logs to stdout/stderr so Render captures them
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

# ── Permissions ───────────────────────────────────────────────────────────────
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ── Startup script ────────────────────────────────────────────────────────────
# Runs at container boot: clears stale cache, migrates, caches, then
# boots PHP-FPM (background) followed by nginx (foreground / PID 1).
# set -e causes the container to exit immediately if any step fails,
# making failures visible in Render's deploy logs.
RUN printf '#!/bin/bash\n\
set -e\n\
echo "[start] Clearing stale caches"\n\
php artisan config:clear\n\
php artisan cache:clear\n\
echo "[start] Running migrations"\n\
php artisan migrate --force\n\
echo "[start] Caching config / routes / views"\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
echo "[start] Starting PHP-FPM"\n\
php-fpm -D\n\
echo "[start] Starting nginx"\n\
exec nginx -g "daemon off;"\n\
' > /usr/local/bin/start.sh && chmod +x /usr/local/bin/start.sh

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
