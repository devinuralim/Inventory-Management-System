FROM composer:2.0 as vendor

COPY . /app
WORKDIR /app
RUN composer install --no-dev --optimize-autoloader

FROM php:8.1-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    && docker-php-ext-install zip pdo pdo_mysql

COPY --from=vendor /app /app

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
