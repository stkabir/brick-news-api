FROM php:8.3-cli-alpine

# System deps for PHP extensions
RUN apk add --no-cache \
    sqlite \
    sqlite-dev \
    oniguruma-dev \
    libxml2-dev \
    curl-dev \
    libzip-dev \
    zip \
    unzip \
    icu-dev \
    && docker-php-ext-install \
        pdo_sqlite \
        mbstring \
        xml \
        dom \
        curl \
        zip \
        intl \
        pcntl \
        bcmath \
        tokenizer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

COPY . .

RUN php artisan package:discover --ansi \
    && php artisan filament:upgrade \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8000

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

ENTRYPOINT ["docker-entrypoint.sh"]
