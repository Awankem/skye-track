# ←←← DELETE THIS LINE (Render still hates it sometimes)
# syntax = docker/dockerfile:1.7

FROM php:8.3-fpm-alpine

# Install nginx + gettext (for envsubst) + all required libs
RUN apk add --no-cache \
    nginx \
    gettext \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo_sqlite pdo_mysql bcmath

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy code
COPY . .

# ←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←
# SQLITE SETUP – this is what kills the 500 error
RUN touch database/database.sqlite && \
    chown www-data:www-data database/database.sqlite && \
    chmod 664 database/database.sqlite && \
    php artisan migrate --force || true && \
    php artisan db:seed --force || true
# ←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←

# Finish composer + Laravel cache
RUN composer dump-autoload --optimize --classmap-authoritative
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Permissions for storage & cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Nginx config as template
COPY docker/nginx/nginx.conf /etc/nginx/http.d/default.conf.template

EXPOSE 8080

# Start PHP-FPM + Nginx
CMD ["/bin/sh", "-c", \
     "envsubst '$PORT' < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf && \
      php-fpm -D && \
      nginx -g 'daemon off;'"]