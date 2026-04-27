# # PHP + Apache base image
# FROM php:8.2-apache

# # System dependencies
# RUN apt-get update && apt-get install -y \
#     git unzip curl zip \
#     libpng-dev libonig-dev libxml2-dev

# # PHP extensions
# RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# # Enable Apache rewrite
# RUN a2enmod rewrite

# # Set Laravel public folder
# ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
#     /etc/apache2/sites-available/000-default.conf

# # Install Node.js (FIX FOR YOUR npm ERROR)
# RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
#     && apt-get install -y nodejs

# # Working directory
# WORKDIR /var/www/html

# # Copy project
# COPY . /var/www/html

# # Composer install
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# RUN composer install --no-interaction --optimize-autoloader

# # Node build
# RUN npm install
# RUN npm run build

# # Permissions
# RUN chown -R www-data:www-data /var/www/html

# EXPOSE 80

# CMD ["apache2-foreground"]

# Use lightweight PHP CLI (no Apache issues)
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libpng-dev libonig-dev libxml2-dev nodejs npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install frontend dependencies and build
RUN npm install
RUN npm run build

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port for Railway
EXPOSE 80

# Start Laravel server
CMD php artisan serve --host=0.0.0.0 --port=80