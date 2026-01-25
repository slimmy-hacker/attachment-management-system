FROM php:8.3-fpm

# Install system dependencies (Adding libzip-dev for the zip extension)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nginx

# Install PHP extensions for MySQL, Zip, and Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory and copy code
WORKDIR /var/www/html
COPY . /var/www/html

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependencies with a flag to ignore platform requirements just in case
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# Configure Nginx for Laravel
RUN echo 'server { \
    listen 80; \
    root /var/www/html/public; \
    index index.php; \
    location / { try_files  / /index.php?; } \
    location ~ \.php$ { \
        include fastcgi_params; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_param SCRIPT_FILENAME ; \
    } \
}' > /etc/nginx/sites-available/default

# Ensure start script is executable
RUN chmod +x /var/www/html/start.sh

EXPOSE 80

CMD ["/var/www/html/start.sh"]
