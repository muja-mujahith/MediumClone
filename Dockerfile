# PHP + Apache base image
FROM php:8.2-apache

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libpng-dev libonig-dev libxml2-dev

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Disable mpm_event by commenting it out in mods-enabled
RUN sed -i 's/^LoadModule mpm_event_module/# LoadModule mpm_event_module/' /etc/apache2/mods-enabled/mpm_event.load || true
# Ensure mpm_prefork is loaded
RUN sed -i 's/^# LoadModule mpm_prefork_module/LoadModule mpm_prefork_module/' /etc/apache2/mods-enabled/mpm_prefork.load || true

# Install Node.js 20.x
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Create required Laravel storage directories and set permissions
RUN mkdir -p storage/framework/cache/data storage/framework/sessions \
    storage/framework/views storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install frontend dependencies and build assets
RUN npm install
RUN npm run build

# Cache Laravel config and routes for production
RUN php artisan config:cache && php artisan route:cache

# Set ownership of the full app to www-data
RUN chown -R www-data:www-data /var/www/html

# Configure Apache to serve from Laravel's public/ directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80

CMD ["apache2-foreground"]
