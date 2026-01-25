FROM dwchiang/nginx-php-fpm:8.3-fpm-bullseye-nginx-1.25.4

# Set working directory
WORKDIR /var/www/html

# Copy the application code
COPY . /var/www/html

# Set the webroot to Laravel's public folder
ENV WEBROOT /var/www/html/public

# Install dependencies without running scripts to avoid Student.php error
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80
