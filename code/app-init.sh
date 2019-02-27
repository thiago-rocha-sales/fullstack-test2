composer install -d ./app

mkdir -p ./app/storage/app/public/images

php ./app/artisan migrate --seed

php ./app/artisan passport:install

composer install -d ./admin

php ./app/artisan key:generate

php-fpm