FROM php:8.3-fpm AS base
WORKDIR /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update \
 && apt-get install -y git libpq-dev libzip-dev zip unzip \
 && docker-php-ext-install pdo_pgsql zip \
 && pecl install apcu \
 && docker-php-ext-enable apcu \
 && rm -rf /var/lib/apt/lists/* \
 && git config --system --add safe.directory /var/www/html

FROM composer:latest AS composer-bin
FROM base AS final

COPY --from=composer-bin /usr/bin/composer /usr/bin/composer
COPY . .


RUN composer install --no-interaction --optimize-autoloader \
 && php artisan package:discover \
 && chmod -R 775 storage bootstrap/cache public \
 && php vendor/bin/openapi app --format yaml --output public/openapi.yaml

EXPOSE 9000
CMD ["php-fpm"]


