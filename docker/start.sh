#!/bin/sh
set -e

# Start PHP-FPM in the background
php-fpm

# Start Nginx in the foreground
nginx -g "daemon off;"
