FROM php:8.3-fpm-alpine

# Install dependencies
RUN apk add --no-cache nginx gettext sqlite sqlite-dev libpng-dev libjpeg-turbo-dev freetype-dev zip libzip-dev oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo_sqlite pdo_mysql bcmath \
    && apk del sqlite-dev

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files first
COPY composer.json composer.lock ./

# Install dependencies with verbose output
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --optimize-autoloader

# Copy application code
COPY . .

# Generate optimized autoloader after all files are in place
RUN composer dump-autoload --optimize --classmap-authoritative

# Create SQLite database + run migrations/seeds
RUN mkdir -p database storage/framework/sessions storage/framework/views storage/framework/cache \
    && touch database/database.sqlite \
    && chown -R www-data:www-data database storage bootstrap/cache \
    && chmod -R 775 database storage bootstrap/cache \
    && php artisan migrate --force \
    && php artisan db:seed --force || true

# Laravel optimization
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Copy nginx config
COPY docker/nginx/nginx.conf /etc/nginx/http.d/default.conf

# Render uses PORT environment variable (default 10000)
EXPOSE 10000

# Start PHP-FPM in background and Nginx in foreground with port substitution
CMD ["/bin/sh", "-c", "sed -i \"s/listen 80/listen ${PORT:-10000}/g\" /etc/nginx/http.d/default.conf && php-fpm & nginx -g 'daemon off;'"]