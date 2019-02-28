composer install -d ./app

mkdir -p ./app/storage/app/public/images

mkdir -p ./app/storage/framework/cache \
    ./app/storage/framework/sessions \
    ./app/storage/framework/views

mkdir -p ./admin/storage/framework/cache \
    ./admin/storage/framework/sessions \
    ./admin/storage/framework/views

php ./app/artisan migrate --seed

php ./app/artisan passport:install

composer install -d ./admin

# php ./app/artisan key:generate

# php-fpm