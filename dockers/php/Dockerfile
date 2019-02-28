FROM php:7-fpm-alpine

RUN apk --update add --no-cache \ 
        postgresql-libs \ 
        postgresql-dev \
        php7-pdo \
        php7-pdo_pgsql \
        nodejs \
        nodejs-npm \
        && docker-php-ext-install pgsql pdo_pgsql \
        && apk del postgresql-dev

RUN rm -Rf /var/cache/apk/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer


RUN set -x ; \
    addgroup -g 1000 -S nginx ; \
    adduser -u 1000 -D -S -G nginx nginx ; exit 0

WORKDIR /var/www

ADD --chown=nginx:nginx ./code /var/www

RUN chmod -R 755 /var/www

USER nginx
