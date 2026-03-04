FROM php:8.3-cli-alpine

RUN apk add --no-cache sqlite sqlite-dev \
    && docker-php-ext-install pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

COPY . .

RUN composer run-script post-autoload-dump || true \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

RUN mkdir -p database storage/logs storage/framework/cache storage/framework/sessions storage/framework/views \
    && touch database/database.sqlite \
    && php artisan migrate --force

EXPOSE 8000

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
