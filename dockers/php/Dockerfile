FROM php:7-fpm-alpine

RUN apk --update add --no-cache \ 
        postgresql-libs \ 
        postgresql-dev \
        php7-pdo \
        php7-pdo_pgsql \
        && docker-php-ext-install pgsql pdo_pgsql \
        && apk del postgresql-dev

RUN rm -Rf /var/cache/apk/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data ; exit 0

COPY --chown=www-data:www-data ./code/app /code/app

# RUN chmod -R 775 /code/app/storage

USER www-data

WORKDIR /code/app
