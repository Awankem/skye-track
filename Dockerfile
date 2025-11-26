FROM php:8.3-fpm-alpine

# Install dependencies
RUN apk add --no-cache nginx gettext sqlite sqlite-dev libpng-dev libjpeg-turbo-dev freetype-dev zip libzip-dev oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo_sqlite pdo_mysql bcmath \
    && apk del sqlite-dev

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy code
COPY . .

# Create SQLite database + run migrations/seeds
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chown www-data:www-data database/database.sqlite \
    && chmod 664 database/database.sqlite \
    && php artisan migrate --force \
    && php artisan db:seed --force || true

# Laravel optimization
RUN composer dump-autoload --optimize --classmap-authoritative
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy nginx config
COPY docker/nginx/nginx.conf /etc/nginx/http.d/default.conf

# Render uses PORT environment variable (default 10000)
EXPOSE 10000

# Start PHP-FPM in background and Nginx in foreground with port substitution
CMD ["/bin/sh", "-c", "sed -i \"s/listen 80/listen ${PORT:-10000}/g\" /etc/nginx/http.d/default.conf && php-fpm & nginx -g 'daemon off;'"]