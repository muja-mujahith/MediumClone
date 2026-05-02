#!/bin/sh
set -e

# Ensure .env exists
if [ ! -f /var/www/html/.env ]; then
    echo "--- No .env found, copying from .env.example ---"
    cp /var/www/html/.env.example /var/www/html/.env
    php artisan key:generate
fi

php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "--- Checking build assets ---"
ls -la /var/www/html/public/build/

echo "--- Running migrations ---"
php artisan migrate --force

echo "--- Creating php-fpm socket directory ---"
mkdir -p /var/run/php

echo "--- Starting php-fpm ---"
php-fpm -D

# Wait for php-fpm socket to be ready
echo "--- Waiting for php-fpm socket ---"
for i in $(seq 1 10); do
    if [ -S /var/run/php/php8.2-fpm.sock ]; then
        echo "php-fpm socket ready."
        break
    fi
    echo "Waiting... ($i)"
    sleep 1
done

echo "--- Starting nginx ---"
nginx -g "daemon off;"