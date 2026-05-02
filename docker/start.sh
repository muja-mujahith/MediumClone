#!/bin/sh
set -e

# Clear Laravel cache (VERY IMPORTANT)
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migrations
php artisan migrate --force

# Start services
php-fpm -D
nginx -g "daemon off;"