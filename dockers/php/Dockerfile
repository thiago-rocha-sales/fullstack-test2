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


# RUN set -x ; \
#     addgroup -g 1000 -S nginx ; \
#     adduser -u 1000 -D -S -G nginx nginx ; exit 0

# USER www-data

COPY --chown=www-data:www-data ./code/app /code/app

RUN chmod -R 755 /code/app

WORKDIR /code/app

USER www-data

# COPY ./vendor /var/www/admin/vendor

# RUN composer install -n -o --no-dev -d ./admin
# RUN composer install
# CMD "composer install -n -o --no-dev -d ./admin"

# RUN php /var/www/app/artisan migrate --seed

# RUN composer install -d ./admin