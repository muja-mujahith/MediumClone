#!/bin/sh
set -e

cd /var/www/html
export PORT=${PORT:-80}
echo "--- PORT is $PORT ---"

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

echo "--- Starting php-fpm ---"
php-fpm -D
sleep 1

echo "--- Waiting for php-fpm on port 9000 ---"
for i in $(seq 1 15); do
    if nc -z 127.0.0.1 9000 2>/dev/null; then
        echo "php-fpm ready."
        break
    fi
    echo "Waiting... ($i/15)"
    sleep 1
done

echo "--- Injecting PORT into nginx config ---"
envsubst '${PORT}' < /etc/nginx/sites-available/default > /tmp/nginx-default
cp /tmp/nginx-default /etc/nginx/sites-available/default

echo "--- Validating nginx config ---"
nginx -t

echo "--- Starting nginx on port $PORT ---"
exec nginx -g "daemon off;"