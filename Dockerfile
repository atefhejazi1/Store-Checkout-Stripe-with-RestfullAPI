FROM php:8.2-fpm

# Install system dependencies + nginx + PostgreSQL client lib
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    libzip-dev zip unzip nodejs npm nginx libpq-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions for PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files (nginx.conf included; .env excluded via .dockerignore)
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies and build assets
RUN npm ci && npm run build

# Wire up nginx config
RUN cp nginx.conf /etc/nginx/sites-available/default

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create startup script:
#   1. Clear any stale config cache
#   2. Run migrations against the PostgreSQL DB (Render injects DB_* env vars)
#   3. Cache config/routes/views for performance
#   4. Start PHP-FPM in background, then nginx in foreground
RUN printf '#!/bin/bash\nset -e\nphp artisan config:clear\nphp artisan migrate --force\nphp artisan config:cache\nphp artisan route:cache\nphp artisan view:cache\nphp-fpm -D\nexec nginx -g "daemon off;"\n' \
    > /usr/local/bin/start.sh && chmod +x /usr/local/bin/start.sh

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
