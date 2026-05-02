#!/bin/sh
set -e

cd /var/www/html
export PORT=${PORT:-80}
echo "=== PORT is $PORT ==="

echo "=== PHP-FPM version ==="
php-fpm -v

echo "=== PHP-FPM config test ==="
php-fpm -t

echo "=== Listing php-fpm pool configs ==="
ls -la /usr/local/etc/php-fpm.d/

echo "=== Contents of www.conf ==="
cat /usr/local/etc/php-fpm.d/www.conf

php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "=== Running migrations ==="
for i in $(seq 1 15); do
    php artisan migrate --force && break
    echo "DB not ready, retrying ($i/15)..."
    sleep 3
done

echo "=== Starting php-fpm ==="
php-fpm -D
sleep 2

echo "=== php-fpm processes ==="
ps aux | grep php

echo "=== Checking port 9000 ==="
netstat -tlnp 2>/dev/null | grep 9000 || echo "Nothing on 9000"

echo "=== Waiting for php-fpm on 9000 ==="
for i in $(seq 1 15); do
    if nc -z 127.0.0.1 9000 2>/dev/null; then
        echo "php-fpm is ready on 9000!"
        break
    fi
    echo "Not ready yet ($i/15)"
    sleep 1
done

echo "=== Final port check ==="
netstat -tlnp 2>/dev/null || ss -tlnp

echo "=== Injecting PORT into nginx ==="
envsubst '${PORT}' < /etc/nginx/sites-available/default > /tmp/nginx-default
cp /tmp/nginx-default /etc/nginx/sites-available/default

echo "=== nginx config contents ==="
cat /etc/nginx/sites-available/default

echo "=== Validating nginx ==="
nginx -t

echo "=== Starting nginx on $PORT ==="
exec nginx -g "daemon off;"