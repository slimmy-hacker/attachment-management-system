# Use the official PHP 8.3 FPM image
FROM php:8.3-fpm

# Install system dependencies for Laravel and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    libzip-dev \
    unzip \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip

# Get the latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory and copy code
WORKDIR /var/www/html
COPY . /var/www/html

# Set correct permissions for Linux
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependencies - we use --no-scripts to bypass that "Student.php" error during build
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Setup Nginx configuration
RUN echo 'server { \
    listen 80; \
    root /var/www/html/public; \
    index index.php index.html; \
    location / { try_files  / /index.php?; } \
    location ~ \.php$ { \
        include fastcgi_params; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_param SCRIPT_FILENAME ; \
    } \
}' > /etc/nginx/sites-available/default

EXPOSE 80

# Start services
CMD service nginx start && php-fpm
