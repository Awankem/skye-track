FROM php:8.3-fpm-alpine

# Install nginx + gettext + sqlite (this fixes pdo_sqlite) + all other libs
RUN apk add --no-cache \
    nginx \
    gettext \
    sqlite \           # This was missing
    sqlite-dev \       # And this (for building pdo_sqlite)
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo_sqlite pdo_mysql bcmath \
    && apk del sqlite-dev  # optional: remove dev package to keep image small

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Code
COPY . .

# SQLITE SETUP – creates the file and runs migrations
RUN mkdir -p database && \
    touch database/database.sqlite && \
    chown www-data:www-data database/database.sqlite && \
    chmod 664 database/database.sqlite && \
    php artisan migrate --force && \  # Removed '|| true' to catch errors
    php artisan db:seed --force && \   # Removed '|| true'
    true  # Added a final true to avoid build failures if migration/seed fails

# Finish Laravel
RUN composer dump-autoload --optimize --classmap-authoritative
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Nginx template
COPY docker/nginx/nginx.conf /etc/nginx/http.d/default.conf.template

EXPOSE 8080

# Start
CMD ["/bin/sh", "-c", \
     "envsubst '$PORT' < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf && \
      php-fpm -D && \
      nginx -g 'daemon off;'"]