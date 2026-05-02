#!/bin/sh
set -e

php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "--- Checking build assets ---"
ls -la /var/www/html/public/build/

php artisan migrate --force

php-fpm -D
nginx -g "daemon off;"