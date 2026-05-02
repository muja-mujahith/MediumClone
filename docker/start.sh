#!/bin/sh
set -e

# Run Laravel migrations before starting services
php artisan migrate --force

# Start PHP-FPM in the background with -D flag
php-fpm -D

# Start Nginx in the foreground
nginx -g "daemon off;"
