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
    && docker-php-ext-install -j$(nproc) gd zip pdo_mysql bcmath

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Code
COPY . .

# Finish composer + Laravel cache
RUN composer dump-autoload --optimize --classmap-authoritative
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Nginx config as template
COPY docker/nginx/nginx.conf /etc/nginx/http.d/default.conf.template

EXPOSE 8080

# Final start command – this is the gold standard in 2025
CMD ["/bin/sh", "-c", \
     "envsubst '$PORT' < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf && \
      php-fpm -D && \
      nginx -g 'daemon off;'"]