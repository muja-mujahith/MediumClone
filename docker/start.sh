#!/bin/sh
set -e

cd /var/www/html

# Use Railway's PORT or default to 80
export PORT=${PORT:-80}

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    echo "--- Generating APP_KEY ---"
    php artisan key:generate --force
fi

php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "--- Checking build assets ---"
ls -la /var/www/html/public/build/

echo "--- Running migrations ---"
for i in $(seq 1 15); do
    php artisan migrate --force && break
    echo "DB not ready, retrying ($i/15)..."
    sleep 3
done

echo "--- Creating php-fpm socket dir ---"
mkdir -p /var/run/php

echo "--- Starting php-fpm ---"
php-fpm -D

echo "--- Waiting for php-fpm socket ---"
for i in $(seq 1 10); do
    [ -S /var/run/php/php8.2-fpm.sock ] && echo "php-fpm ready." && break
    sleep 1
done

echo "--- Injecting PORT=$PORT into nginx config ---"
envsubst '$PORT' < /etc/nginx/sites-available/default > /tmp/nginx-default
cp /tmp/nginx-default /etc/nginx/sites-available/default

echo "--- Starting nginx on port $PORT ---"
nginx -g "daemon off;"