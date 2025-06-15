FROM php:8.3-fpm

RUN apt-get update && apt-get install -y git unzip curl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www/html
COPY laravel/ ./
RUN composer install --no-interaction --prefer-dist \
    && npm install \
    && npm run build

CMD ["php-fpm"]
