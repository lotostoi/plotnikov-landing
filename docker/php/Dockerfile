FROM php:8.4-cli

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libzip-dev libsqlite3-dev libicu-dev pkg-config \
    && docker-php-ext-install pdo_sqlite zip intl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

CMD ["sh", "-lc", "if [ ! -f vendor/autoload.php ]; then composer install --no-interaction --prefer-dist; fi && php artisan serve --host=0.0.0.0 --port=8080"]
