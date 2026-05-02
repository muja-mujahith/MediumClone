FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx git unzip curl zip \
    libpng-dev libonig-dev libxml2-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www/html
COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev

ENV NODE_ENV=production
RUN npm install --include=dev
RUN npm run build

RUN mkdir -p storage/framework/cache/data storage/framework/sessions \
    storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# PHP-FPM config (uses Unix socket)
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Nginx config
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Entrypoint
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]