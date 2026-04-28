FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
        git \
        unzip \
        libzip-dev \
        sqlite-dev \
        icu-dev \
        $PHPIZE_DEPS \
    && docker-php-ext-install pdo_sqlite zip intl opcache \
    && apk del $PHPIZE_DEPS \
    && rm -rf /var/cache/apk/*

COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

EXPOSE 9000
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
