# STAGE 1: Composer
FROM composer:latest AS composer_builder
WORKDIR /app
COPY src/composer.json src/composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs

# STAGE 2: Node (Vite/Breeze)
FROM node:20-alpine AS node_builder
WORKDIR /app
COPY src/package.json src/package-lock.json src/vite.config.js ./
COPY src/resources ./resources
COPY src/public ./public
RUN npm install && npm run build

# STAGE 3: PHP
FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    unzip \
    postgresql-dev \ 
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip bcmath gd \
    && rm -rf /var/cache/apk/*

WORKDIR /var/www/html

# 1. Copy Vendor & Build Assets
COPY --from=composer_builder /app/vendor ./vendor
COPY --from=node_builder /app/public/build ./public/build

# 2. Copy Source Code & Set Permissions
COPY src/ .

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 3. Final Composer Autoload
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer dump-autoload --no-dev --optimize --no-scripts

USER www-data
EXPOSE 9000
CMD ["php-fpm"]