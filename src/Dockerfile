# ==========================================
# STAGE 1: Composer (Dependency Builder)
# ==========================================
FROM composer:latest AS composer_builder
WORKDIR /app
COPY composer.json composer.lock ./
# Hindari eksekusi script otomatis saat build
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs

# ==========================================
# STAGE 2: Node (Vite/Tailwind Compiler)
# ==========================================
FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
# TAMBAHAN KRUSIAL: Salin config Tailwind
COPY tailwind.config.js postcss.config.js* ./ 
COPY resources ./resources
COPY public ./public
RUN npm install && npm run build

# ==========================================
# STAGE 3: PHP (Production Runtime)
# ==========================================
FROM php:8.3-fpm-alpine


RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    unzip \
    postgresql-dev \ 
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql zip bcmath gd \
    && rm -rf /var/cache/apk/*

WORKDIR /var/www/html

COPY . .


COPY --from=composer_builder /app/vendor ./vendor
COPY --from=node_builder /app/public/build ./public/build

# Setup permission untuk user www-data (Nginx/PHP)
RUN mkdir -p storage/framework/views \
             storage/framework/cache \
             storage/framework/sessions \
             storage/logs \
             bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache


ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer dump-autoload --no-dev --optimize


USER www-data
EXPOSE 9000
CMD ["php-fpm"]