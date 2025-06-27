# Используем официальный PHP 8.3 FPM образ
FROM php:8.3-fpm

# Устанавливаем необходимые пакеты
RUN apt-get update && apt-get install -y \
    gnupg \
    curl \
    ca-certificates \
    zip \
    unzip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libpq-dev \
    zlib1g-dev \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Копируем конфигурацию Nginx в контейнер
COPY ./nginx/default.conf /etc/nginx/sites-available/default

# Копируем файлы проекта в контейнер
COPY . /var/www/html

# Устанавливаем права для каталога проекта
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

# Открываем порты для Nginx и PHP
EXPOSE 80

# Запуск Nginx и PHP-FPM
CMD service nginx start && php-fpm
